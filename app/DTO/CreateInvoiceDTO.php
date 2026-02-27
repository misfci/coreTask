<?php

namespace App\DTOs;

class CreateInvoiceDTO
{
    public function __construct(
        public readonly int $contractId
    ) {}

    /**
     * ميثود ثابتة لتحويل الـ Request لـ DTO
     */
    public static function fromRequest($request, $contract): self
    {
        return new self(
            contractId: $contract->id
        );
    }
}