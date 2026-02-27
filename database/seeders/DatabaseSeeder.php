<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{
    // 1. إنشاء Tenant
    $tenant = \App\Models\Tenant::create(['name' => 'Core Tech Company']);

    // 2. إنشاء يوزر مربوط بالـ Tenant (ده اللي هنستخدمه في التيست)
    $user = \App\Models\User::factory()->create([
        'name' => 'Mohammed Ibrahim',
        'email' => 'test@example.com',
        'tenant_id' => $tenant->id,
        'password' => bcrypt('password123'),
    ]);

    // 3. إنشاء عقد نشط لنفس الـ Tenant
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
