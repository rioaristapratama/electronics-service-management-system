<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DeviceCategory;
use App\Models\ServiceItem;
use App\Models\ServiceOrder;
use App\Models\ServiceStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan servis.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $serviceOrders = ServiceOrder::with(['customer', 'receivedBy'])
            ->withCount('serviceItems')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhere('received_from_name', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($customerQuery) use ($search) {
                            $customerQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('received_at')
            ->paginate(10)
            ->withQueryString();

        return view('service-orders.index', compact(
            'serviceOrders',
            'search'
        ));
    }

    /**
     * Menampilkan form penerimaan perangkat.
     */
    public function create()
    {
        $customers = Customer::with(['contacts' => function ($query) {
            $query->where('is_active', true)
                ->orderByDesc('is_primary');
        }])
            ->orderBy('name')
            ->get();

        $categories = DeviceCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $customerContactData = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'contacts' => $customer->contacts->map(function ($contact) {
                    return [
                        'id' => $contact->id,
                        'name' => $contact->contact_name,
                        'phone' => $contact->phone,
                    ];
                })->values(),
            ];
        })->values();

        return view('service-orders.create', compact(
            'customers',
            'categories',
            'customerContactData'
        ));
    }

    /**
     * Menyimpan pesanan servis beserta perangkat dan riwayat status awal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                'integer',
                Rule::exists('customers', 'id'),
            ],

            'received_from_name' => [
                'required',
                'string',
                'max:150',
            ],

            'received_from_phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'received_from_relationship' => [
                'nullable',
                'string',
                Rule::in([
                    'Pemilik perangkat sendiri',
                    'Keluarga',
                    'Teman',
                    'Rekan kerja',
                    'Karyawan',
                    'Kurir',
                    'Lainnya',
                ]),
            ],

            'received_from_relationship_other' => [
                'nullable',
                'string',
                'max:100',
                'required_if:received_from_relationship,Lainnya',
            ],

            'general_notes' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.category_id' => [
                'required',
                'integer',
                Rule::exists('device_categories', 'id')
                    ->where('is_active', true),
            ],

            'items.*.brand' => [
                'nullable',
                'string',
                'max:100',
            ],

            'items.*.model' => [
                'nullable',
                'string',
                'max:100',
            ],

            'items.*.serial_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'items.*.complaint' => [
                'required',
                'string',
            ],

            'items.*.physical_condition' => [
                'nullable',
                'string',
            ],

            'items.*.accessories' => [
                'nullable',
                'string',
            ],
        ]);

        $serviceOrder = DB::transaction(function () use ($validated) {

            // Menentukan hubungan penerima perangkat.
            $relationship = ($validated['received_from_relationship'] ?? null) === 'Lainnya'
                ? $validated['received_from_relationship_other']
                : ($validated['received_from_relationship'] ?? null);

            // Membuat nomor pesanan unik.
            do {
                $orderNumber = 'SRV-' . now()->format('Ymd')
                    . '-' . Str::upper(Str::random(6));
            } while (ServiceOrder::where('order_number', $orderNumber)->exists());

            // Membuat pesanan utama.
            $order = new ServiceOrder([
                'order_number' => $orderNumber,
                'customer_id' => $validated['customer_id'],
                'received_at' => now(),
                'received_from_name' => $validated['received_from_name'],
                'received_from_phone' => $validated['received_from_phone'] ?? null,
                'received_from_relationship' => $relationship,
                'general_notes' => $validated['general_notes'] ?? null,
            ]);

            // Penerima pesanan diambil dari akun yang sedang login.
            $order->received_by = Auth::id();
            $order->save();

            // Menyimpan seluruh perangkat dalam satu pesanan.
            foreach ($validated['items'] as $itemData) {

                // Mengambil nama kategori perangkat.
                $categoryName = DeviceCategory::whereKey($itemData['category_id'])
                    ->value('name');

                // Membuat nama perangkat otomatis.
                $deviceName = trim(implode(' ', array_filter([
                    $categoryName,
                    $itemData['brand'] ?? null,
                    $itemData['model'] ?? null,
                ])));

                $deviceName = Str::limit($deviceName, 150, '');

                $item = new ServiceItem([
                    'device_name' => $deviceName,
                    'category_id' => $itemData['category_id'],
                    'brand' => $itemData['brand'] ?? null,
                    'model' => $itemData['model'] ?? null,
                    'serial_number' => $itemData['serial_number'] ?? null,
                    'complaint' => $itemData['complaint'],
                    'physical_condition' => $itemData['physical_condition'] ?? null,
                    'accessories' => $itemData['accessories'] ?? null,
                ]);

                $order->serviceItems()->save($item);

                // Status awal ditetapkan secara eksplisit.
                $item->current_status = 'DITERIMA';
                $item->save();

                // Membuat riwayat status awal.
                $history = new ServiceStatusHistory([
                    'service_item_id' => $item->id,
                    'old_status' => null,
                    'new_status' => 'DITERIMA',
                    'changed_at' => now(),
                    'reason' => 'Perangkat diterima oleh workshop.',
                ]);

                $history->changed_by = Auth::id();;
                $history->save();
            }

            return $order;
        });

        return redirect()
            ->route('service-orders.show', $serviceOrder)
            ->with('success', 'Pesanan servis berhasil dibuat.');
    }

    /**
     * Menampilkan detail pesanan, perangkat, diagnosis,
     * estimasi biaya, dan riwayat persetujuan pelanggan.
     */
    public function show(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load([
            'customer.contacts',
            'receivedBy',

            'serviceItems.category',

            // Riwayat diagnosis setiap perangkat
            'serviceItems.diagnoses.diagnosedBy',

            // Riwayat estimasi biaya dan pembuat estimasi
            'serviceItems.estimateHistories.recordedBy',

            // Riwayat persetujuan pelanggan
            'serviceItems.estimateHistories.approvalHistories.customerContact',
            'serviceItems.estimateHistories.approvalHistories.recordedBy',
        ]);

        // Urutkan riwayat dari yang terbaru
        $serviceOrder->serviceItems->each(function ($item) {
            $item->setRelation(
                'diagnoses',
                $item->diagnoses->sortByDesc('diagnosed_at')->values()
            );

            $item->setRelation(
                'estimateHistories',
                $item->estimateHistories
                    ->sortByDesc('estimated_at')
                    ->values()
            );
        });

        return view('service-orders.show', compact('serviceOrder'));
    }
}
