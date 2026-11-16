<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Owner',
                'description' => 'Pemilik usaha dengan akses tertinggi ke seluruh fitur sistem.',
            ],
            [
                'name' => 'Admin',
                'description' => 'Mengelola pelanggan, pesanan servis, pembayaran, dan administrasi.',
            ],
            [
                'name' => 'Technician',
                'description' => 'Menangani diagnosis, proses perbaikan, dan hasil servis perangkat.',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
