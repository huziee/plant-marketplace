<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\ShippingMethod;

class ShippingService
{
    public function getAvailableMethods(float $subtotal): array
    {
        $methods = ShippingMethod::active()->get();
        $available = [];

        foreach ($methods as $method) {
            $cost = (float) $method->price;

            if ($method->free_shipping_threshold !== null && $subtotal >= (float) $method->free_shipping_threshold) {
                $cost = 0.00;
            }

            $available[] = [
                'id' => $method->id,
                'name' => $method->name,
                'code' => $method->code,
                'description' => $method->description,
                'cost' => $cost,
                'is_free' => $cost === 0.00,
            ];
        }

        return $available;
    }

    public function calculateCost(ShippingMethod $method, float $subtotal): float
    {
        if ($method->free_shipping_threshold !== null && $subtotal >= (float) $method->free_shipping_threshold) {
            return 0.00;
        }

        return (float) $method->price;
    }
}
