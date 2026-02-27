<?php

namespace App\DTO;

class CreateInvoiceDTO
{
    public function __construct(
        public readonly int $contractId
    ) {
    }

    public static function fromRequest($request, $contract): self
    {
        return new self(
            contractId: $contract->id
        );
    }
}
