<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithPermissions(
        string $roleName,
        array $permissionNames
    ): User {
        $role = Role::create([
            'name' => $roleName,
            'description' => 'Role untuk pengujian pelanggan',
        ]);

        foreach ($permissionNames as $permissionName) {
            $permission = Permission::create([
                'name' => $permissionName,
                'description' => 'Permission pengujian',
            ]);

            $role->permissions()->attach($permission->id);
        }

        return User::factory()->create([
            'role_id' => $role->id,
            'is_active' => true,
        ]);
    }


    public function test_owner_can_create_customer(): void
    {
        $user = $this->createUserWithPermissions(
            'Owner',
            ['customers.view', 'customers.manage']
        );

        $response = $this->actingAs($user)
            ->post(route('customers.store'), [
                'name' => 'Pelanggan Pertama',
                'notes' => 'Pelanggan pengujian',
                'contact_name' => 'Kontak Pertama',
                'phone' => '081234567890',
                'whatsapp_consent' => '1',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('customers', [
            'name' => 'Pelanggan Pertama',
            'notes' => 'Pelanggan pengujian',
        ]);

        $customer = Customer::where('name', 'Pelanggan Pertama')->firstOrFail();

        $this->assertDatabaseHas('customer_contacts', [
            'customer_id' => $customer->id,
            'contact_name' => 'Kontak Pertama',
            'phone' => '081234567890',
            'is_primary' => true,
            'whatsapp_consent' => true,
            'is_active' => true,
        ]);
    }


    public function test_admin_can_access_customer_management(): void
    {
        $user = $this->createUserWithPermissions(
            'Admin',
            ['customers.view', 'customers.manage']
        );

        $response = $this->actingAs($user)
            ->get(route('customers.create'));

        $response->assertOk();
    }

    public function test_technician_can_view_customers_but_cannot_manage_them(): void
    {
        $user = $this->createUserWithPermissions(
            'Technician',
            ['customers.view']
        );

        $customer = Customer::create([
            'name' => 'Pelanggan Teknisi',
            'notes' => 'Data untuk pengujian',
        ]);

        $indexResponse = $this->actingAs($user)
            ->get(route('customers.index'));

        $indexResponse->assertOk();
        $indexResponse->assertSee('Pelanggan Teknisi');
        $indexResponse->assertDontSee(route('customers.create'));

        $detailResponse = $this->get(route('customers.show', $customer));

        $detailResponse->assertOk();
        $detailResponse->assertDontSee(route('customers.edit', $customer));

        $createResponse = $this->post(route('customers.store'), [
            'name' => 'Pelanggan Tidak Diizinkan',
        ]);

        $createResponse->assertForbidden();

        $updateResponse = $this->put(
            route('customers.update', $customer),
            ['name' => 'Nama Diubah Teknisi']
        );

        $updateResponse->assertForbidden();

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Pelanggan Teknisi',
        ]);
    }

    public function test_user_without_customers_view_permission_gets_forbidden(): void
    {
        $user = $this->createUserWithPermissions(
            'Staff',
            []
        );

        $response = $this->actingAs($user)
            ->get(route('customers.index'));

        $response->assertForbidden();
    }

    public function test_customer_can_be_searched_by_name_or_phone(): void
    {
        $user = $this->createUserWithPermissions(
            'Owner',
            ['customers.view']
        );

        $customer = Customer::create([
            'name' => 'Pelanggan Pencarian',
        ]);

        CustomerContact::create([
            'customer_id' => $customer->id,
            'contact_name' => 'Kontak Utama',
            'phone' => '081234567890',
            'is_primary' => true,
            'whatsapp_consent' => true,
            'is_active' => true,
        ]);

        $nameResponse = $this->actingAs($user)
            ->get(route('customers.index', ['search' => 'Pencarian']));

        $nameResponse->assertOk();
        $nameResponse->assertSee('Pelanggan Pencarian');

        $phoneResponse = $this->get(
            route('customers.index', ['search' => '081234567890'])
        );

        $phoneResponse->assertOk();
        $phoneResponse->assertSee('Pelanggan Pencarian');
    }

    public function test_customer_can_be_updated(): void
    {
        $user = $this->createUserWithPermissions(
            'Owner',
            ['customers.view', 'customers.manage']
        );

        $customer = Customer::create([
            'name' => 'Nama Sebelum Diubah',
        ]);

        $response = $this->actingAs($user)
            ->put(route('customers.update', $customer), [
                'name' => 'Nama Setelah Diubah',
                'notes' => 'Catatan baru',
            ]);

        $response->assertRedirect(
            route('customers.show', $customer)
        );

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Nama Setelah Diubah',
            'notes' => 'Catatan baru',
        ]);
    }


    public function test_contact_name_defaults_to_customer_name_when_empty(): void
    {
        $user = $this->createUserWithPermissions(
            'Owner',
            ['customers.view', 'customers.manage']
        );

        $this->actingAs($user)
            ->post(route('customers.store'), [
                'name' => 'Poyen',
                'phone' => '089765456781',
            ])
            ->assertRedirect();

        $customer = Customer::where('name', 'Poyen')->firstOrFail();

        $this->assertDatabaseHas('customer_contacts', [
            'customer_id' => $customer->id,
            'contact_name' => 'Poyen',
            'phone' => '089765456781',
            'is_primary' => true,
            'is_active' => true,
        ]);
    }
}
