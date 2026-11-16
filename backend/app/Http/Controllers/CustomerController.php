<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = Customer::query()
            ->withCount(['contacts', 'serviceOrders'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhereHas('contacts', function ($contactQuery) use ($search) {
                            $contactQuery->where('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.form', [
            'customer' => new Customer(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'contact_name' => ['nullable', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp_consent' => ['sometimes', 'boolean'],
        ]);

        $customer = DB::transaction(function () use ($validated) {
            $customer = Customer::create([
                'name' => $validated['name'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $customer->contacts()->create([
                'contact_name' => filled($validated['contact_name'] ?? null)
                    ? $validated['contact_name']
                    : $customer->name,
                'phone' => $validated['phone'],
                'is_primary' => true,
                'whatsapp_consent' => $validated['whatsapp_consent'] ?? false,
                'is_active' => true,
            ]);

            return $customer;
        });

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Pelanggan dan kontak pertamanya berhasil ditambahkan.');
    }

    public function show(Customer $customer): View
    {
        $customer->load([
            'contacts' => function ($query) {
                $query->orderByDesc('is_primary')
                    ->orderBy('id');
            },

            'serviceOrders' => function ($query) {
                $query->withCount('serviceItems')
                    ->with([
                        'serviceItems:id,service_order_id,current_status',
                        'receivedBy',
                    ])
                    ->latest('received_at')
                    ->limit(10);
            },
        ]);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer): View
    {
        return view('customers.form', [
            'customer' => $customer,
            'isEdit' => true,
        ]);
    }

    public function update(
        Request $request,
        Customer $customer
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $customer->update($validated);

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }
}
