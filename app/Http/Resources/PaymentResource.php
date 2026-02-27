<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'amount'           => $this->amount,
            'payment_method'   => $this->payment_method,
            'reference_number' => 'REF-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
            'paid_at'          => $this->paid_at,
        ];
    }
}
