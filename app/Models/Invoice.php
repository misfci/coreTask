<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InvoiceStatus;
class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'invoice_number', 'subtotal', 'tax_amount', 'total', 'status', 'due_date', 'paid_at', 'tenant_id'];

    // protected $casts = [
    //     'status' => InvoiceStatus::class,
    //     'paid_at' => 'datetime', // بنعرفه إن ده تاريخ عشان نقدر نستخدم ميزات التواريخ في PHP
    // ];

    protected function casts(): array
    {
        return [
            'status' => InvoiceStatus::class,
            'paid_at' => 'datetime',
        ];
    }

    // علاقة: الفاتورة تتبع عقد واحد 
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    // علاقة: الفاتورة ممكن يكون ليها كذا عملية دفع (Partially Paid) 
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
