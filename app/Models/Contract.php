<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ContractStatus;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = ['tenant_id', 'unit_name', 'customer_name', 'rent_amount', 'start_date', 'end_date', 'status'];
    // أهم حتة: بنقول للموديل إن حالة العقد نوعها Enum مش String عادي 
protected function casts(): array
{
    return [
        'status' => ContractStatus::class,
    ];
}

    // علاقة: العقد الواحد له فواتير كتير 
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
