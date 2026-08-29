<?php

namespace App\Services;

use App\Enums\InventoryMovementType;
use App\Enums\StockStatus;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryService
{
    public function decreaseStock(Product $product, int $quantity, ?ProductVariant $variant = null, ?string $referenceType = null, ?int $referenceId = null, ?string $notes = null, ?User $user = null): bool
    {
        return DB::transaction(function () use ($product, $quantity, $variant, $referenceType, $referenceId, $notes, $user) {
            if ($variant) {
                $target = ProductVariant::where('id', $variant->id)->lockForUpdate()->first();
            } else {
                $target = Product::where('id', $product->id)->lockForUpdate()->first();
            }

            if (!$target) {
                return false;
            }

            $before = (int) $target->stock_quantity;
            $after = max(0, $before - $quantity);
            $target->stock_quantity = $after;

            // Recalculate stock status
            $target->stock_status = $this->calculateStockStatus($target);
            $target->save();

            InventoryMovement::create([
                'product_id' => $product->id,
                'product_variant_id' => $variant?->id,
                'type' => InventoryMovementType::SALE->value,
                'quantity' => -$quantity,
                'quantity_before' => $before,
                'quantity_after' => $after,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'notes' => $notes ?: "Stock decreased by {$quantity}",
                'created_by' => $user?->id,
            ]);

            if ($after <= ($target->low_stock_threshold ?? 5)) {
                Log::warning("Low stock alert for product #{$product->id} ({$product->name}): Current stock is {$after}");
            }

            return true;
        });
    }

    public function increaseStock(Product $product, int $quantity, ?ProductVariant $variant = null, InventoryMovementType $type = InventoryMovementType::RESTOCK, ?string $referenceType = null, ?int $referenceId = null, ?string $notes = null, ?User $user = null): bool
    {
        return DB::transaction(function () use ($product, $quantity, $variant, $type, $referenceType, $referenceId, $notes, $user) {
            if ($variant) {
                $target = ProductVariant::where('id', $variant->id)->lockForUpdate()->first();
            } else {
                $target = Product::where('id', $product->id)->lockForUpdate()->first();
            }

            if (!$target) {
                return false;
            }

            $before = (int) $target->stock_quantity;
            $after = $before + $quantity;
            $target->stock_quantity = $after;
            $target->stock_status = $this->calculateStockStatus($target);
            $target->save();

            InventoryMovement::create([
                'product_id' => $product->id,
                'product_variant_id' => $variant?->id,
                'type' => $type->value,
                'quantity' => $quantity,
                'quantity_before' => $before,
                'quantity_after' => $after,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'notes' => $notes ?: "Stock increased by {$quantity}",
                'created_by' => $user?->id,
            ]);

            return true;
        });
    }

    public function checkStock(Product $product, int $quantity, ?ProductVariant $variant = null): bool
    {
        if ($variant) {
            return $variant->stock_quantity >= $quantity || $product->allow_backorder;
        }

        if (!$product->track_inventory) {
            return true;
        }

        return $product->stock_quantity >= $quantity || $product->allow_backorder;
    }

    protected function calculateStockStatus($target): StockStatus
    {
        $qty = (int) $target->stock_quantity;
        $lowThreshold = (int) ($target->low_stock_threshold ?? 5);

        if ($qty <= 0) {
            return StockStatus::OUT_OF_STOCK;
        }

        if ($qty <= $lowThreshold) {
            return StockStatus::LOW_STOCK;
        }

        return StockStatus::IN_STOCK;
    }
}
