<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ContractStatus;
use App\Models\Scopes\TenantScope;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'unit_name', 'customer_name', 'rent_amount', 'start_date', 'end_date', 'status'];
    protected $casts = [
        'status' => \App\Enums\ContractStatus::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
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
