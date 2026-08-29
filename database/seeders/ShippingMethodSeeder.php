<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Standard Express Courier',
                'code' => 'standard',
                'description' => 'Delivered in 2-4 business days across Pakistan.',
                'type' => 'flat_rate',
                'price' => 250.00,
                'free_shipping_threshold' => 3500.00,
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'name' => 'Local Nursery Pickup',
                'code' => 'pickup',
                'description' => 'Pick up directly from our flagship nursery garden center.',
                'type' => 'pickup',
                'price' => 0.00,
                'free_shipping_threshold' => 0.00,
                'status' => 'active',
                'sort_order' => 2,
            ],
        ];

        foreach ($methods as $m) {
            ShippingMethod::updateOrCreate(
                ['code' => $m['code']],
                $m
            );
        }
    }
}
