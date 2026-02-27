<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InvoiceStatus;
use App\Models\Scopes\TenantScope;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'invoice_number', 'subtotal', 'tax_amount', 'total', 'status', 'due_date', 'paid_at', 'tenant_id'];

    protected $casts = [
        'status' => \App\Enums\InvoiceStatus::class,
        'paid_at' => 'datetime',
        'due_date' => 'datetime'
    ];
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            // لو اليوزر مسجل دخول ومبعتناش tenant_id يدوي، حط بتاع اليوزر
            if (auth()->check() && !$model->tenant_id) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
}
