<?php

namespace App\Services;

use App\Models\Currency;

class ExchangeRateService
{
    public static function convert(float $amount, string $fromCurrency, string $toCurrency = 'IDR'): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $from = Currency::where('code', $fromCurrency)->first();
        $to = Currency::where('code', $toCurrency)->first();

        if (!$from || !$to) {
            return $amount;
        }

        $inBase = $amount * $from->exchange_rate;

        return $inBase / $to->exchange_rate;
    }

    public static function updateRates(): void
    {
        // Placeholder for API-based rate update
        // Can be extended with exchangerate-api.com or similar
    }
}
