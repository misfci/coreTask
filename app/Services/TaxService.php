<?php

namespace App\Services;

class TaxService
{
    public function calculateTax(float $amount): float
    {
        return $amount * 0.15;
    }
}
