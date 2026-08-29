<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case PROCESSING = 'processing';
    case PACKED = 'packed';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::PROCESSING => 'Processing',
            self::PACKED => 'Packed',
            self::SHIPPED => 'Shipped',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'bg-warning text-dark',
            self::CONFIRMED => 'bg-info text-white',
            self::PROCESSING => 'bg-primary text-white',
            self::PACKED => 'bg-indigo text-white',
            self::SHIPPED => 'bg-primary-subtle text-primary',
            self::DELIVERED => 'bg-success text-white',
            self::CANCELLED => 'bg-danger text-white',
            self::REFUNDED => 'bg-secondary text-white',
        };
    }
}
