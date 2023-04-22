<?php

namespace App\Enums;

enum LogActionsEnum
{
    case REMOVED_PRODUCT;
    case ADDED_PRODUCT;
    case CHECKED_OUT_CART;

    public function name(): string
    {
        return match ($this) {
            self::REMOVED_PRODUCT => 'Removed Product',
            self::ADDED_PRODUCT => 'Added Product',
            self::CHECKED_OUT_CART => 'Checked out Cart',
        };
    }

    public static function all(): array
    {
        return [
            self::REMOVED_PRODUCT->name => 'Removed Product',
            self::ADDED_PRODUCT->name => 'Added Product',
            self::CHECKED_OUT_CART->name => 'Checked out Cart',
        ];
    }
}
