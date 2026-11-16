<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'dashboard.view', 'description' => 'Melihat dashboard'],
            ['name' => 'users.view', 'description' => 'Melihat daftar pengguna'],
            ['name' => 'users.manage', 'description' => 'Mengelola pengguna dan role'],
            ['name' => 'customers.view', 'description' => 'Melihat data pelanggan'],
            ['name' => 'customers.manage', 'description' => 'Mengelola data pelanggan'],
            ['name' => 'service_orders.view', 'description' => 'Melihat pesanan servis'],
            ['name' => 'service_orders.create', 'description' => 'Membuat pesanan servis'],
            ['name' => 'service_orders.manage', 'description' => 'Mengelola pesanan servis'],
            ['name' => 'diagnoses.manage', 'description' => 'Mengelola diagnosis perangkat'],
            ['name' => 'repairs.manage', 'description' => 'Mengelola proses dan hasil perbaikan'],
            ['name' => 'components.view', 'description' => 'Melihat data komponen'],
            ['name' => 'components.manage', 'description' => 'Mengelola data komponen'],
            ['name' => 'payments.view', 'description' => 'Melihat pembayaran'],
            ['name' => 'payments.manage', 'description' => 'Mengelola pembayaran dan refund'],
            ['name' => 'reports.view', 'description' => 'Melihat laporan usaha'],
            ['name' => 'settings.manage', 'description' => 'Mengelola pengaturan sistem'],
            ['name' => 'audit_logs.view', 'description' => 'Melihat catatan aktivitas sistem'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                [
                    'description' => $permission['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
