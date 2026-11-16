<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerContactController extends Controller
{
    /**
     * Menambahkan kontak pelanggan.
     */
    public function store(
        Request $request,
        Customer $customer
    ): RedirectResponse {
        $validated = $request->validate([
            'contact_name' => ['nullable', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'is_primary' => ['sometimes', 'boolean'],
            'whatsapp_consent' => ['sometimes', 'boolean'],
        ]);

        DB::transaction(function () use ($customer, $validated) {
            $isPrimary = $validated['is_primary'] ?? false;

            if ($isPrimary) {
                $customer->contacts()
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->update(['is_primary' => false]);
            }

            $customer->contacts()->create([
                'contact_name' => $validated['contact_name'] ?? null,
                'phone' => $validated['phone'],
                'is_primary' => $isPrimary,
                'whatsapp_consent' => $validated['whatsapp_consent'] ?? false,
                'is_active' => true,
            ]);
        });

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Kontak pelanggan berhasil ditambahkan.');
    }

    /**
     * Memperbarui kontak pelanggan.
     */
    public function update(
        Request $request,
        Customer $customer,
        CustomerContact $contact
    ): RedirectResponse {
        abort_unless(
            $contact->customer_id === $customer->id,
            404
        );

        $validated = $request->validate([
            'contact_name' => ['nullable', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'is_primary' => ['sometimes', 'boolean'],
            'whatsapp_consent' => ['sometimes', 'boolean'],
        ]);

        DB::transaction(function () use ($customer, $contact, $validated) {
            $isPrimary = $validated['is_primary'] ?? false;

            if ($isPrimary && $contact->is_active) {
                $customer->contacts()
                    ->where('id', '!=', $contact->id)
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->update(['is_primary' => false]);
            }

            $contact->update([
                'contact_name' => filled($validated['contact_name'] ?? null)
                    ? $validated['contact_name']
                    : $customer->name,
                'phone' => $validated['phone'],
                'is_primary' => $contact->is_active ? $isPrimary : false,
                'whatsapp_consent' => $validated['whatsapp_consent'] ?? false,
            ]);
        });

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Kontak pelanggan berhasil diperbarui.');
    }

    /**
     * Mengubah status aktif kontak.
     */
    public function toggleStatus(
        Customer $customer,
        CustomerContact $contact
    ): RedirectResponse {
        abort_unless(
            $contact->customer_id === $customer->id,
            404
        );

        DB::transaction(function () use ($contact) {
            $contact->update([
                'is_active' => ! $contact->is_active,
                'is_primary' => false,
            ]);
        });

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Status kontak berhasil diperbarui.');
    }
}
