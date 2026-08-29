<?php

namespace App\Services;

class TaxService
{
    public function calculateTax(float $taxableSubtotal): float
    {
        $enabled = setting('shop_tax_enabled', false);
        if (!$enabled) {
            return 0.00;
        }

        $rate = (float) setting('shop_tax_rate', 0);
        if ($rate <= 0) {
            return 0.00;
        }

        return round(($taxableSubtotal * $rate) / 100, 2);
    }
}
