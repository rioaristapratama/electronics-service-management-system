<?php

namespace Tests\Feature\Auth;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithPermission(
        string $roleName,
        ?string $permissionName = null
    ): User {
        $role = Role::create([
            'name' => $roleName,
            'description' => 'Role untuk pengujian',
        ]);

        if ($permissionName !== null) {
            $permission = Permission::create([
                'name' => $permissionName,
                'description' => 'Permission untuk pengujian',
            ]);

            $role->permissions()->attach($permission->id);
        }

        return User::factory()->create([
            'role_id' => $role->id,
            'is_active' => true,
        ]);
    }

    public function test_user_with_users_view_permission_can_access_user_list(): void
    {
        $user = $this->createUserWithPermission(
            'Owner',
            'users.view'
        );

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertOk();
    }

    public function test_user_without_users_view_permission_gets_forbidden(): void
    {
        $user = $this->createUserWithPermission(
            'Technician',
            'customers.view'
        );

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_user_without_users_manage_permission_cannot_create_users(): void
    {
        $user = $this->createUserWithPermission(
            'Technician',
            'users.view'
        );

        $response = $this->actingAs($user)
            ->get(route('users.create'));

        $response->assertForbidden();
    }
}
