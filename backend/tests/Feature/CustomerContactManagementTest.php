<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerContactManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithPermissions(array $permissionNames): User
    {
        $role = Role::create([
            'name' => 'Owner',
            'description' => 'Role pengujian kontak',
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

    public function test_user_can_add_customer_contact(): void
    {
        $user = $this->createUserWithPermissions([
            'customers.view',
            'customers.manage',
        ]);

        $customer = Customer::create([
            'name' => 'Pelanggan Pengujian',
        ]);

        $response = $this->actingAs($user)
            ->post(route('customers.contacts.store', $customer), [
                'contact_name' => 'Kontak Utama',
                'phone' => '081234567890',
                'is_primary' => '1',
                'whatsapp_consent' => '1',
            ]);

        $response->assertRedirect(route('customers.show', $customer));

        $this->assertDatabaseHas('customer_contacts', [
            'customer_id' => $customer->id,
            'contact_name' => 'Kontak Utama',
            'phone' => '081234567890',
            'is_primary' => true,
            'whatsapp_consent' => true,
            'is_active' => true,
        ]);
    }

    public function test_new_primary_contact_replaces_previous_primary_contact(): void
    {
        $user = $this->createUserWithPermissions([
            'customers.view',
            'customers.manage',
        ]);

        $customer = Customer::create([
            'name' => 'Pelanggan Pengujian',
        ]);

        $firstContact = $customer->contacts()->create([
            'contact_name' => 'Kontak Pertama',
            'phone' => '081111111111',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post(route('customers.contacts.store', $customer), [
                'contact_name' => 'Kontak Kedua',
                'phone' => '082222222222',
                'is_primary' => '1',
            ])
            ->assertRedirect(route('customers.show', $customer));

        $this->assertDatabaseHas('customer_contacts', [
            'id' => $firstContact->id,
            'is_primary' => false,
        ]);

        $this->assertDatabaseHas('customer_contacts', [
            'customer_id' => $customer->id,
            'phone' => '082222222222',
            'is_primary' => true,
        ]);
    }

    public function test_user_can_update_customer_contact(): void
    {
        $user = $this->createUserWithPermissions([
            'customers.view',
            'customers.manage',
        ]);

        $customer = Customer::create([
            'name' => 'Pelanggan Pengujian',
        ]);

        $contact = $customer->contacts()->create([
            'contact_name' => 'Nama Lama',
            'phone' => '081111111111',
            'is_primary' => false,
            'whatsapp_consent' => false,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->put(route('customers.contacts.update', [$customer, $contact]), [
                'contact_name' => 'Nama Baru',
                'phone' => '089999999999',
                'is_primary' => '1',
                'whatsapp_consent' => '1',
            ]);

        $response->assertRedirect(route('customers.show', $customer));

        $this->assertDatabaseHas('customer_contacts', [
            'id' => $contact->id,
            'contact_name' => 'Nama Baru',
            'phone' => '089999999999',
            'is_primary' => true,
            'whatsapp_consent' => true,
        ]);
    }

    public function test_user_can_toggle_contact_status(): void
    {
        $user = $this->createUserWithPermissions([
            'customers.view',
            'customers.manage',
        ]);

        $customer = Customer::create([
            'name' => 'Pelanggan Pengujian',
        ]);

        $contact = $customer->contacts()->create([
            'contact_name' => 'Kontak Utama',
            'phone' => '081234567890',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->patch(route('customers.contacts.toggle-status', [$customer, $contact]))
            ->assertRedirect(route('customers.show', $customer));

        $this->assertDatabaseHas('customer_contacts', [
            'id' => $contact->id,
            'is_active' => false,
            'is_primary' => false,
        ]);

        $this->patch(
            route('customers.contacts.toggle-status', [$customer, $contact])
        )->assertRedirect(route('customers.show', $customer));

        $this->assertDatabaseHas('customer_contacts', [
            'id' => $contact->id,
            'is_active' => true,
            'is_primary' => false,
        ]);
    }

    public function test_user_cannot_update_contact_belonging_to_another_customer(): void
    {
        $user = $this->createUserWithPermissions([
            'customers.view',
            'customers.manage',
        ]);

        $customerA = Customer::create([
            'name' => 'Pelanggan A',
        ]);

        $customerB = Customer::create([
            'name' => 'Pelanggan B',
        ]);

        $contact = $customerB->contacts()->create([
            'contact_name' => 'Kontak B',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->put(route('customers.contacts.update', [$customerA, $contact]), [
                'contact_name' => 'Nama Diubah',
                'phone' => '089999999999',
            ])
            ->assertNotFound();

        $this->assertDatabaseHas('customer_contacts', [
            'id' => $contact->id,
            'customer_id' => $customerB->id,
            'contact_name' => 'Kontak B',
            'phone' => '081234567890',
        ]);
    }

    public function test_user_without_manage_permission_cannot_manage_contacts(): void
    {
        $user = $this->createUserWithPermissions([
            'customers.view',
        ]);

        $customer = Customer::create([
            'name' => 'Pelanggan Pengujian',
        ]);

        $response = $this->actingAs($user)
            ->post(route('customers.contacts.store', $customer), [
                'contact_name' => 'Kontak',
                'phone' => '081234567890',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseCount('customer_contacts', 0);
    }
}
