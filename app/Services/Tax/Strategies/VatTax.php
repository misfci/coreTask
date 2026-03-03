<?php

namespace App\Services\Tax\Strategies;

use App\Services\Tax\Interfaces\TaxCalculatorInterface;

class VatTax implements TaxCalculatorInterface 
{
    public function calculate(float $amount): float 
    { 
        return $amount * 0.15; 
    }
}