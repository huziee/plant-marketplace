<?php

namespace App\Enums;

enum InventoryMovementType: string
{
    case INITIAL = 'initial';
    case PURCHASE = 'purchase';
    case SALE = 'sale';
    case RETURN = 'return';
    case RESTOCK = 'restock';
    case ADJUSTMENT = 'adjustment';
    case DAMAGE = 'damage';
    case CANCELLED_ORDER_RESTORE = 'cancelled_order_restore';

    public function label(): string
    {
        return match ($this) {
            self::INITIAL => 'Initial Stock',
            self::PURCHASE => 'Purchase / Restock',
            self::SALE => 'Customer Sale',
            self::RETURN => 'Customer Return',
            self::RESTOCK => 'Restock',
            self::ADJUSTMENT => 'Manual Adjustment',
            self::DAMAGE => 'Damaged / Expired',
            self::CANCELLED_ORDER_RESTORE => 'Order Cancellation Restore',
        };
    }
}
