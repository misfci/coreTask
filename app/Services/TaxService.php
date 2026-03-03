<?php

namespace App\Services;

class TaxService
{
    protected array $calculators = [];

    public function addCalculator($calculator)
    {
        $this->calculators[] = $calculator;
    }

    public function calculateTax(float $amount): float
    {
        $totalTax = 0;
        foreach ($this->calculators as $calculator) {
            $totalTax += $calculator->calculate($amount);
        }
        return $totalTax;
    }
}