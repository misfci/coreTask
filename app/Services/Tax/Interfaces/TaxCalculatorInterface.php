<?php

namespace App\Services\Tax\Interfaces;

interface TaxCalculatorInterface
{
    public function calculate(float $amount): float;
}