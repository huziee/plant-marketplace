<?php

namespace App\Services;

use App\Enums\InventoryMovementType;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    public function updateStatus(Order $order, OrderStatus $newStatus, ?string $notes = null, ?User $user = null): Order
    {
        return DB::transaction(function () use ($order, $newStatus, $notes, $user) {
            $fromStatus = $order->status;

            if ($fromStatus === $newStatus) {
                return $order;
            }

            $order->status = $newStatus->value;

            if ($newStatus === OrderStatus::DELIVERED) {
                $order->delivered_at = now();
                if ($order->payment_method === 'cash_on_delivery') {
                    $order->payment_status = PaymentStatus::PAID->value;
                    $order->paid_at = now();
                    $order->payments()->update(['status' => PaymentStatus::PAID->value, 'paid_at' => now()]);
                }
            } elseif ($newStatus === OrderStatus::SHIPPED) {
                $order->shipped_at = now();
            } elseif ($newStatus === OrderStatus::CANCELLED) {
                $order->cancelled_at = now();
                $this->restoreOrderInventory($order, $user);
            }

            $order->save();

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'from_status' => $fromStatus->value,
                'to_status' => $newStatus->value,
                'notes' => $notes,
                'changed_by' => $user?->id,
            ]);

            return $order;
        });
    }

    public function cancelOrder(Order $order, ?string $reason = null, ?User $user = null): Order
    {
        if (!$order->canBeCancelled()) {
            throw new \InvalidArgumentException('Order cannot be cancelled in its current state.');
        }

        return $this->updateStatus($order, OrderStatus::CANCELLED, $reason ?: 'Order cancelled by customer', $user);
    }

    protected function restoreOrderInventory(Order $order, ?User $user = null): void
    {
        foreach ($order->items as $item) {
            if ($item->product) {
                $this->inventoryService->increaseStock(
                    $item->product,
                    $item->quantity,
                    $item->variant,
                    InventoryMovementType::CANCELLED_ORDER_RESTORE,
                    'Order',
                    $order->id,
                    "Stock restored due to Order #{$order->order_number} cancellation",
                    $user
                );
            }
        }
    }
}
