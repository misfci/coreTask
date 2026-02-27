<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Contract;

class InvoicePolicy
{
    public function view(User $user, Contract $contract): bool
    {
        return $user->tenant_id === $contract->tenant_id;
    }

    public function show(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->tenant_id;
    }


    public function create(User $user, Contract $contract): bool
    {
        return $user->tenant_id === $contract->tenant_id;
    }

    public function recordPayment(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->tenant_id
               && $invoice->status !== \App\Enums\InvoiceStatus::CANCELLED;
    }
}
