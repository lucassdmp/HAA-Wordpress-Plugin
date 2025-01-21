<?php

namespace HAAPlugin\Common\Enum;

if (!defined('ABSPATH')) {
    exit;
}

enum WooCommerceStatus : int
{
    case wc_completed = 0;
    case wc_cancelled = 1;
    case trash = 99;

    /**
     * Map a string to the corresponding WooCommerceStatus enum case
     *
     * @param string $wcstatus
     * @return WooCommerceStatus|null
     */
    public static function fromString(string $wcstatus): ?WooCommerceStatus
    {
        return match ($wcstatus){
            "wc-completed" => self::wc_completed,
            "wc-cancelled" => self::wc_cancelled,
            "trash" => self::trash,
            default => null,
        };
    }

    
}