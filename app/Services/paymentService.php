<?php

namespace App\Services;

use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;

class PaymentService
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private InvoiceRepositoryInterface $invoiceRepository,
    ) {
    }
}
