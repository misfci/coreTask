<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Contract;

class InvoicePolicy
{
    /**
     * هل مسموح لليوزر يشوف تفاصيل فاتورة معينة؟
     */
    public function view(User $user, Invoice $invoice): bool
    {
        // لازم الفاتورة تتبع عقد يخص الـ Tenant بتاع اليوزر
        return $user->tenant_id === $invoice->contract->tenant_id;
    }

    /**
     * هل مسموح لليوزر ينشئ فاتورة لعقد معين؟
     */
    public function create(User $user, Contract $contract): bool
    {
        // لازم العقد يخص الـ Tenant بتاع اليوزر
        return $user->tenant_id === $contract->tenant_id;
    }

    /**
     * هل مسموح لليوزر يسجل دفع لفاتورة؟
     */
    public function recordPayment(User $user, Invoice $invoice): bool
    {
        // 1. لازم الفاتورة تخص الـ Tenant بتاعه
        // 2. الفاتورة الملغاة لا يمكن الدفع لها (حسب Business Rule صفحة 9)
        return $user->tenant_id === $invoice->contract->tenant_id 
               && $invoice->status !== \App\Enums\InvoiceStatus::CANCELLED;
    }
}