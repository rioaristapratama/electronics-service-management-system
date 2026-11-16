<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptop',
                'description' => 'Perangkat komputer portabel.',
            ],
            [
                'name' => 'Komputer / PC',
                'description' => 'Komputer desktop dan perangkat sejenis.',
            ],
            [
                'name' => 'Printer',
                'description' => 'Printer inkjet, laser, dan perangkat cetak.',
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Telepon pintar berbagai merek.',
            ],
            [
                'name' => 'Tablet',
                'description' => 'Perangkat komputer tablet.',
            ],
            [
                'name' => 'Monitor',
                'description' => 'Monitor komputer dan layar eksternal.',
            ],
            [
                'name' => 'Perangkat Jaringan',
                'description' => 'Router, switch, modem, dan perangkat jaringan.',
            ],
            [
                'name' => 'Elektronik Lainnya',
                'description' => 'Perangkat elektronik lain yang diterima bengkel.',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('device_categories')->updateOrInsert(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
