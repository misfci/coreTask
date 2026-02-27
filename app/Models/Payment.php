<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentMethod;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_id', 'amount', 'payment_method', 'reference_number', 'paid_at'];


    protected function casts(): array
    {
        return [
            'status' => PaymentMethod::class,
            'paid_at' => 'datetime',
        ];
    }

    // علاقة: الدفع يتبع فاتورة واحدة 
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
