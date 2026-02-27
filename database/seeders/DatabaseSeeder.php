<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

public function run(): void
{
    $tenant = \App\Models\Tenant::create(['name' => 'Core Tech Company']);

    $user = \App\Models\User::factory()->create([
        'name' => 'Mohammed Ibrahim',
        'email' => 'test@example.com',
        'tenant_id' => $tenant->id,
        'password' => bcrypt('password123'),
    ]);

    \App\Models\Contract::create([
        'tenant_id' => $tenant->id,
        'contract_number' => 'CONT-001',
        'customer_name' => 'mohamed Ibrahim',
        'rent_amount' => 1000,
        'status' => 'active',
        'unit_name' => 'Unit A-101',
        'start_date' => now(),
        'end_date' => now()->addYear(),
    ]);
}
}
