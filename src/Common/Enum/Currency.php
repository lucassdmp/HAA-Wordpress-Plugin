<?php

namespace HAAPlugin\Common\Enum;

if (!defined('ABSPATH')) {
    exit;
}

enum Currency: int
{

    case BRL = 0;
    case EUR = 1;
    case USD = 2;

    /**
     * Get the list of all available currencies
     *
     * @return array
     */
    public static function getAvailableCurrencies(): array
    {
        return [
            self::USD,
            self::BRL,
            self::EUR,
        ];
    }

    /**
     * Map a string to the corresponding Currency enum case
     *
     * @param string $currency
     * @return Currency|null
     */
    public static function fromString(string $currency): ?Currency
    {
        return match ($currency) {
            'USD' => self::USD,
            'BRL' => self::BRL,
            'EUR' => self::EUR,
            default => null,
        };
    }
}
