<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'contract_id' => $this->contract_id,
            'tenant_id' => $this->tenant_id,
            'subtotal' => number_format($this->subtotal, 2),
            'tax_amount' => number_format($this->tax_amount, 2),
            'total' => number_format($this->total, 2),
            'status' => $this->status,
            'due_date' => $this->due_date->format('Y-m-d'),
            'paid_at' => $this->paid_at?->format('Y-m-d'),
            'notes' => $this->notes,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
