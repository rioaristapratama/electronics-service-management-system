<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $rolePermissions = [
            'Owner' => [
                'dashboard.view',
                'users.view',
                'users.manage',
                'customers.view',
                'customers.manage',
                'service_orders.view',
                'service_orders.create',
                'service_orders.manage',
                'diagnoses.manage',
                'repairs.manage',
                'components.view',
                'components.manage',
                'payments.view',
                'payments.manage',
                'reports.view',
                'settings.manage',
                'audit_logs.view',
            ],

            'Admin' => [
                'dashboard.view',
                'customers.view',
                'customers.manage',
                'service_orders.view',
                'service_orders.create',
                'service_orders.manage',
                'diagnoses.manage',
                'components.view',
                'components.manage',
                'payments.view',
                'payments.manage',
                'reports.view',
            ],

            'Technician' => [
                'dashboard.view',
                'customers.view',
                'service_orders.view',
                'diagnoses.manage',
                'repairs.manage',
                'components.view',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = DB::table('roles')
                ->where('name', $roleName)
                ->first();

            if (!$role) {
                throw new \RuntimeException("Role {$roleName} tidak ditemukan.");
            }

            foreach ($permissionNames as $permissionName) {
                $permission = DB::table('permissions')
                    ->where('name', $permissionName)
                    ->first();

                if (!$permission) {
                    throw new \RuntimeException(
                        "Permission {$permissionName} tidak ditemukan."
                    );
                }

                DB::table('role_permissions')->updateOrInsert(
                    [
                        'role_id' => $role->id,
                        'permission_id' => $permission->id,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
