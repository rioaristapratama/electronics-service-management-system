<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        $ownerRole = DB::table('roles')
            ->where('name', 'Owner')
            ->first();

        if (!$ownerRole) {
            throw new \RuntimeException('Role Owner belum tersedia.');
        }

        $email = config('services.owner.email');
        $password = config('services.owner.password');

        if (!$email || !$password) {
            throw new \RuntimeException(
                'OWNER_EMAIL dan OWNER_PASSWORD harus diatur di file .env.'
            );
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Owner',
                'password' => Hash::make($password),
                'role_id' => $ownerRole->id,
                'phone' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
