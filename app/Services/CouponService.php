<?php

namespace App\Services;

use App\Enums\CouponType;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\User;

class CouponService
{
    public function validateCoupon(string $code, float $subtotal, ?User $user = null): array
    {
        $code = strtoupper(trim($code));
        $coupon = Coupon::active()->where('code', $code)->first();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or expired coupon code.'];
        }

        if ($coupon->minimum_order !== null && $subtotal < (float) $coupon->minimum_order) {
            $formatted = number_format($coupon->minimum_order, 0);
            return ['valid' => false, 'message' => "This coupon requires a minimum order subtotal of Rs. {$formatted}."];
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its maximum global limit.'];
        }

        if ($user && $coupon->usage_per_user !== null) {
            $userUsage = CouponUsage::where('coupon_id', $coupon->id)->where('user_id', $user->id)->count();
            if ($userUsage >= $coupon->usage_per_user) {
                return ['valid' => false, 'message' => 'You have reached your personal usage limit for this coupon.'];
            }
        }

        $discount = $this->calculateDiscount($coupon, $subtotal);

        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount' => $discount,
            'message' => 'Coupon applied successfully!',
        ];
    }

    public function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->type === CouponType::FIXED) {
            $discount = (float) $coupon->value;
        } else {
            $discount = ($subtotal * (float) $coupon->value) / 100;
            if ($coupon->maximum_discount !== null && $discount > (float) $coupon->maximum_discount) {
                $discount = (float) $coupon->maximum_discount;
            }
        }

        return round(min($subtotal, max(0, $discount)), 2);
    }
}
