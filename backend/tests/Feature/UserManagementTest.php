<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Membuat role beserta permission untuk kebutuhan pengujian.
     */
    private function createRoleWithPermissions(
        string $roleName,
        array $permissionNames
    ): Role {
        $role = Role::create([
            'name' => $roleName,
            'description' => 'Role untuk pengujian',
        ]);

        foreach ($permissionNames as $permissionName) {
            $permission = Permission::create([
                'name' => $permissionName,
                'description' => 'Permission untuk pengujian',
            ]);

            $role->permissions()->attach($permission->id);
        }

        return $role;
    }

    /**
     * Membuat pengguna aktif dengan role tertentu.
     */
    private function createUserWithRole(Role $role): User
    {
        return User::factory()->create([
            'role_id' => $role->id,
            'is_active' => true,
        ]);
    }

    public function test_owner_can_create_user(): void
    {
        $ownerRole = $this->createRoleWithPermissions(
            'Owner',
            ['users.view', 'users.manage', 'settings.manage']
        );

        $technicianRole = Role::create([
            'name' => 'Technician',
            'description' => 'Role teknisi',
        ]);

        $owner = $this->createUserWithRole($ownerRole);

        $response = $this->actingAs($owner)->post(route('users.store'), [
            'name' => 'Teknisi Baru',
            'email' => 'teknisi@example.com',
            'phone' => '08123456789',
            'role_id' => $technicianRole->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Teknisi Baru',
            'email' => 'teknisi@example.com',
            'role_id' => $technicianRole->id,
            'is_active' => true,
        ]);
    }

    public function test_user_without_users_manage_permission_cannot_store_user(): void
    {
        $technicianRole = $this->createRoleWithPermissions(
            'Technician',
            ['users.view']
        );

        $targetRole = Role::create([
            'name' => 'Admin',
            'description' => 'Role admin',
        ]);

        $technician = $this->createUserWithRole($technicianRole);

        $response = $this->actingAs($technician)->post(route('users.store'), [
            'name' => 'Pengguna Baru',
            'email' => 'baru@example.com',
            'role_id' => $targetRole->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
        ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('users', [
            'email' => 'baru@example.com',
        ]);
    }

    public function test_user_without_users_manage_permission_cannot_update_user(): void
    {
        $technicianRole = $this->createRoleWithPermissions(
            'Technician',
            ['users.view']
        );

        $targetRole = Role::create([
            'name' => 'Admin',
            'description' => 'Role admin',
        ]);

        $technician = $this->createUserWithRole($technicianRole);
        $targetUser = $this->createUserWithRole($targetRole);

        $response = $this->actingAs($technician)
            ->put(route('users.update', $targetUser), [
                'name' => 'Nama Diubah',
                'email' => $targetUser->email,
                'role_id' => $targetRole->id,
                'is_active' => true,
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('users', [
            'id' => $targetUser->id,
            'name' => 'Nama Diubah',
        ]);
    }

    public function test_user_without_settings_manage_cannot_assign_owner_role(): void
    {
        // Admin memiliki users.manage, tetapi tidak memiliki settings.manage.
        $adminRole = $this->createRoleWithPermissions(
            'Admin',
            ['users.view', 'users.manage']
        );

        $ownerRole = Role::create([
            'name' => 'Owner',
            'description' => 'Role pemilik sistem',
        ]);

        $admin = $this->createUserWithRole($adminRole);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Calon Owner',
            'email' => 'calonowner@example.com',
            'role_id' => $ownerRole->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
        ]);

        $response->assertSessionHasErrors('role_id');

        $this->assertDatabaseMissing('users', [
            'email' => 'calonowner@example.com',
        ]);
    }

    public function test_user_cannot_deactivate_own_account(): void
    {
        $ownerRole = $this->createRoleWithPermissions(
            'Owner',
            ['users.view', 'users.manage', 'settings.manage']
        );

        $owner = $this->createUserWithRole($ownerRole);

        $response = $this->actingAs($owner)
            ->put(route('users.update', $owner), [
                'name' => $owner->name,
                'email' => $owner->email,
                'phone' => $owner->phone,
                'role_id' => $owner->role_id,
                'is_active' => false,
            ]);

        $response->assertSessionHasErrors('is_active');

        $this->assertDatabaseHas('users', [
            'id' => $owner->id,
            'is_active' => true,
        ]);
    }

    public function test_user_cannot_change_own_role(): void
    {
        $ownerRole = $this->createRoleWithPermissions(
            'Owner',
            ['users.view', 'users.manage', 'settings.manage']
        );

        $technicianRole = Role::create([
            'name' => 'Technician',
            'description' => 'Role teknisi',
        ]);

        $owner = $this->createUserWithRole($ownerRole);

        $response = $this->actingAs($owner)
            ->put(route('users.update', $owner), [
                'name' => $owner->name,
                'email' => $owner->email,
                'role_id' => $technicianRole->id,
                'is_active' => true,
            ]);

        $response->assertSessionHasErrors('role_id');

        $this->assertDatabaseHas('users', [
            'id' => $owner->id,
            'role_id' => $ownerRole->id,
        ]);
    }

    public function test_last_active_owner_cannot_be_deactivated_by_another_user(): void
    {
        $adminRole = $this->createRoleWithPermissions(
            'Admin',
            ['users.view', 'users.manage', 'settings.manage']
        );

        $ownerRole = Role::create([
            'name' => 'Owner',
            'description' => 'Role pemilik sistem',
        ]);

        $operator = $this->createUserWithRole($adminRole);

        // Hanya ada satu Owner aktif.
        $targetOwner = $this->createUserWithRole($ownerRole);

        $response = $this->actingAs($operator)
            ->put(route('users.update', $targetOwner), [
                'name' => $targetOwner->name,
                'email' => $targetOwner->email,
                'phone' => $targetOwner->phone,
                'role_id' => $targetOwner->role_id,
                'is_active' => false,
            ]);

        $response->assertSessionHasErrors('role_id');

        $this->assertDatabaseHas('users', [
            'id' => $targetOwner->id,
            'is_active' => true,
        ]);
    }

    public function test_last_active_owner_cannot_be_demoted_by_another_user(): void
    {
        $adminRole = $this->createRoleWithPermissions(
            'Admin',
            ['users.view', 'users.manage', 'settings.manage']
        );

        $ownerRole = Role::create([
            'name' => 'Owner',
            'description' => 'Role pemilik sistem',
        ]);

        $technicianRole = Role::create([
            'name' => 'Technician',
            'description' => 'Role teknisi',
        ]);

        $operator = $this->createUserWithRole($adminRole);

        // Hanya ada satu Owner aktif.
        $targetOwner = $this->createUserWithRole($ownerRole);

        $response = $this->actingAs($operator)
            ->put(route('users.update', $targetOwner), [
                'name' => $targetOwner->name,
                'email' => $targetOwner->email,
                'phone' => $targetOwner->phone,
                'role_id' => $technicianRole->id,
                'is_active' => true,
            ]);

        $response->assertSessionHasErrors('role_id');

        $this->assertDatabaseHas('users', [
            'id' => $targetOwner->id,
            'role_id' => $ownerRole->id,
            'is_active' => true,
        ]);
    }
}
