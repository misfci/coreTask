<?php

namespace App\DTO;

class RecordPaymentDTO
{
    public function __construct(
        public readonly int $invoiceId,
        public readonly float $amount,
        public readonly string $paymentMethod
    ) {
    }

    public static function fromRequest($request, $invoice): self
    {
        return new self(
            invoiceId: $invoice->id,
            amount: $request->validated()['amount'],
            paymentMethod: $request->validated()['payment_method']
        );
    }
}
