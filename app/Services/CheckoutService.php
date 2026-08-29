<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Cart;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService,
        protected InventoryService $inventoryService,
        protected ShippingService $shippingService,
        protected CouponService $couponService,
        protected TaxService $taxService
    ) {}

    public function processCheckout(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = $this->cartService->getCart($user);

            if ($cart->items->isEmpty()) {
                throw new \InvalidArgumentException('Your cart is empty.');
            }

            // 1. Lock and validate stock for all items
            foreach ($cart->items as $item) {
                if (!$this->inventoryService->checkStock($item->product, $item->quantity, $item->variant)) {
                    throw new \InvalidArgumentException("Item '{$item->product->name}' does not have enough stock available.");
                }
            }

            $subtotal = $cart->subtotal;

            // 2. Shipping calculation
            $shippingMethod = ShippingMethod::findOrFail($data['shipping_method_id']);
            $shippingTotal = $this->shippingService->calculateCost($shippingMethod, $subtotal);

            // 3. Coupon validation & calculation
            $discountTotal = 0.00;
            $couponId = null;

            if (!empty($data['coupon_code'])) {
                $couponRes = $this->couponService->validateCoupon($data['coupon_code'], $subtotal, $user);
                if ($couponRes['valid']) {
                    $discountTotal = $couponRes['discount'];
                    $couponId = $couponRes['coupon']->id;
                }
            }

            // 4. Tax calculation
            $taxableSubtotal = max(0, $subtotal - $discountTotal);
            $taxTotal = $this->taxService->calculateTax($taxableSubtotal);

            $grandTotal = max(0, $subtotal - $discountTotal + $shippingTotal + $taxTotal);

            // 5. Create Order Record
            $orderNumber = 'PLT-' . date('Y') . '-' . str_pad((string) (Order::count() + 1), 6, '0', STR_PAD_LEFT);

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'status' => OrderStatus::PENDING->value,
                'payment_status' => PaymentStatus::PENDING->value,
                'payment_method' => $data['payment_method'] ?? 'cash_on_delivery',
                'currency' => setting('shop_currency', 'PKR'),
                'subtotal' => $subtotal,
                'discount_total' => $discountTotal,
                'shipping_total' => $shippingTotal,
                'tax_total' => $taxTotal,
                'grand_total' => $grandTotal,
                'coupon_id' => $couponId,
                'customer_email' => $data['shipping_address']['email'] ?? $user->email,
                'customer_phone' => $data['shipping_address']['phone'] ?? $user->phone ?? '0000000000',
                'billing_address' => $data['billing_address'] ?? $data['shipping_address'],
                'shipping_address' => $data['shipping_address'],
                'customer_notes' => $data['customer_notes'] ?? null,
                'placed_at' => now(),
            ]);

            // 6. Create Order Items & Deduct Inventory
            foreach ($cart->items as $item) {
                $unitPrice = $item->variant ? $item->variant->effective_price : (float) $item->product->price;
                $lineTotal = round($unitPrice * $item->quantity, 2);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->product->name,
                    'variant_name' => $item->variant?->name,
                    'sku' => $item->variant?->sku ?: $item->product->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                    'product_snapshot' => [
                        'name' => $item->product->name,
                        'slug' => $item->product->slug,
                        'sku' => $item->product->sku,
                        'variant' => $item->variant?->name,
                        'price' => $unitPrice,
                    ],
                ]);

                // Deduct stock cleanly
                $this->inventoryService->decreaseStock(
                    $item->product,
                    $item->quantity,
                    $item->variant,
                    'Order',
                    $order->id,
                    "Stock deducted for Order #{$order->order_number}",
                    $user
                );
            }

            // 7. Record Coupon Usage
            if ($couponId && $discountTotal > 0) {
                CouponUsage::create([
                    'coupon_id' => $couponId,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'discount_amount' => $discountTotal,
                ]);

                DB::table('coupons')->where('id', $couponId)->increment('used_count');
            }

            // 8. Payment Record Initialization (Cash on Delivery)
            Payment::create([
                'order_id' => $order->id,
                'provider' => $data['payment_method'] ?? 'cash_on_delivery',
                'transaction_id' => 'COD-' . Str::upper(Str::random(10)),
                'amount' => $grandTotal,
                'currency' => setting('shop_currency', 'PKR'),
                'status' => PaymentStatus::PENDING->value,
            ]);

            // 9. Clear Cart
            $this->cartService->clearCart($cart);

            return $order;
        });
    }
}
