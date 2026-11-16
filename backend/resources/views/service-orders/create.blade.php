    @extends('layouts.app')

    @section('title', 'Penerimaan Servis')

    @section('page-heading', 'Penerimaan Servis Baru')

    @section('content')
        <div class="mx-auto max-w-5xl space-y-6">

            {{-- Header --}}
            <div>
                <a href="{{ route('service-orders.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                    </svg>
                    Kembali ke Pesanan Servis
                </a>

                <div class="mt-4">
                    <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Penerimaan Perangkat Servis
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Catat informasi pelanggan, penerima, dan perangkat yang akan diperbaiki.
                    </p>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-500/30 dark:bg-red-500/10">
                    <div class="flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mt-0.5 h-5 w-5 shrink-0 text-red-600 dark:text-red-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                        </svg>

                        <div>
                            <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                                Periksa kembali data yang dimasukkan:
                            </p>
                            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-300">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('service-orders.store') }}" class="space-y-6">
                @csrf

                {{-- 1. Customer Information --}}
                <section
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-700 sm:px-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                                01
                            </span>
                            <div>
                                <h3 class="font-semibold text-slate-900 dark:text-white">
                                    Informasi Pelanggan
                                </h3>
                                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                    Pilih pelanggan yang sudah terdaftar.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5 p-5 sm:p-6">

                        <div>
                            <label for="customer_id"
                                class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Pelanggan <span class="text-red-500">*</span>
                            </label>

                            <select id="customer_id" name="customer_id" required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                                <option value="">-- Pilih Pelanggan --</option>

                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                Pelanggan harus sudah terdaftar di Customer Management.
                            </p>
                        </div>

                        <div>
                            <label for="contact_id"
                                class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Gunakan Kontak Pelanggan
                            </label>

                            <select id="contact_id" name="contact_id" disabled
                                class="w-full rounded-xl border border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-500 outline-none disabled:cursor-not-allowed disabled:opacity-70 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-400">
                                <option value="">-- Pilih kontak (opsional) --</option>
                            </select>

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                Pilihan ini membantu mengisi nama dan nomor penerima secara otomatis.
                            </p>
                        </div>

                    </div>
                </section>

                {{-- 2. Recipient Information --}}
                <section
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-700 sm:px-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                                02
                            </span>
                            <div>
                                <h3 class="font-semibold text-slate-900 dark:text-white">
                                    Informasi Penerima Perangkat
                                </h3>
                                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                    Identitas orang yang menyerahkan perangkat.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5 p-5 sm:p-6">

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="received_from_name"
                                    class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Nama Penerima / Penyerah <span class="text-red-500">*</span>
                                </label>

                                <input type="text" id="received_from_name" name="received_from_name"
                                    value="{{ old('received_from_name') }}" maxlength="150"
                                    placeholder="Nama orang yang menyerahkan perangkat" required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-500">
                            </div>

                            <div>
                                <label for="received_from_phone"
                                    class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Nomor Telepon
                                </label>

                                <input type="tel" id="received_from_phone" name="received_from_phone"
                                    value="{{ old('received_from_phone') }}" maxlength="20"
                                    placeholder="Contoh: 081234567890"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-500">
                            </div>
                        </div>

                        <div>
                            <label for="received_from_relationship"
                                class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Hubungan dengan Pemilik / Pelanggan
                            </label>

                            <select id="received_from_relationship" name="received_from_relationship"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                                <option value="">-- Pilih Hubungan --</option>

                                @foreach (['Pemilik perangkat sendiri', 'Keluarga', 'Teman', 'Rekan kerja', 'Karyawan', 'Kurir', 'Lainnya'] as $relationship)
                                    <option value="{{ $relationship }}" @selected(old('received_from_relationship') === $relationship)>
                                        {{ $relationship }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="other-relationship-container"
                            class="{{ old('received_from_relationship') === 'Lainnya' ? '' : 'hidden' }}">
                            <label for="received_from_relationship_other"
                                class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Jelaskan Hubungan Lainnya <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="received_from_relationship_other"
                                name="received_from_relationship_other" maxlength="100"
                                value="{{ old('received_from_relationship_other') }}"
                                placeholder="Tuliskan hubungan dengan pelanggan"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                        </div>

                    </div>
                </section>

                {{-- 3. Device List --}}
                <section
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">

                    <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-700 sm:px-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                                    03
                                </span>
                                <div>
                                    <h3 class="font-semibold text-slate-900 dark:text-white">
                                        Daftar Perangkat
                                    </h3>
                                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                        Satu pesanan dapat mencakup beberapa perangkat.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 p-5 sm:p-6" id="items-container">

                        @php
                            $oldItems = old('items', [
                                [
                                    'category_id' => '',
                                    'brand' => '',
                                    'model' => '',
                                    'serial_number' => '',
                                    'complaint' => '',
                                    'physical_condition' => '',
                                    'accessories' => '',
                                ],
                            ]);
                        @endphp

                        @foreach ($oldItems as $index => $item)
                            <div
                                class="device-item overflow-hidden rounded-xl border border-slate-200 dark:border-slate-600">

                                <div
                                    class="flex items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-600 dark:bg-slate-900/50">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="device-number flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <strong
                                            class="item-title text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            Perangkat {{ $loop->iteration }}
                                        </strong>
                                    </div>

                                    <button type="button"
                                        class="remove-item rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40 dark:text-red-400 dark:hover:bg-red-500/10"
                                        @disabled(count($oldItems) === 1)>
                                        Hapus
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 gap-5 p-4 md:grid-cols-2">

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Kategori Perangkat <span class="text-red-500">*</span>
                                        </label>

                                        <select name="items[{{ $index }}][category_id]" required
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                                            <option value="">-- Pilih Kategori --</option>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(($item['category_id'] ?? '') == $category->id)>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Merek
                                        </label>

                                        <input type="text" name="items[{{ $index }}][brand]"
                                            value="{{ $item['brand'] ?? '' }}" maxlength="100"
                                            placeholder="Contoh: ASUS"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Model
                                        </label>

                                        <input type="text" name="items[{{ $index }}][model]"
                                            value="{{ $item['model'] ?? '' }}" maxlength="100"
                                            placeholder="Contoh: X441U"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Nomor Seri
                                        </label>

                                        <input type="text" name="items[{{ $index }}][serial_number]"
                                            value="{{ $item['serial_number'] ?? '' }}" maxlength="100"
                                            placeholder="Nomor seri perangkat"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Keluhan Kerusakan <span class="text-red-500">*</span>
                                        </label>

                                        <textarea name="items[{{ $index }}][complaint]" rows="3" required
                                            placeholder="Jelaskan keluhan yang disampaikan pelanggan"
                                            class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">{{ $item['complaint'] ?? '' }}</textarea>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Kondisi Fisik Awal
                                        </label>

                                        <textarea name="items[{{ $index }}][physical_condition]" rows="3"
                                            placeholder="Contoh: layar retak, casing lecet"
                                            class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">{{ $item['physical_condition'] ?? '' }}</textarea>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                            Aksesori yang Disertakan
                                        </label>

                                        <textarea name="items[{{ $index }}][accessories]" rows="3"
                                            placeholder="Contoh: charger, tas laptop, kabel"
                                            class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">{{ $item['accessories'] ?? '' }}</textarea>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{-- Add Device Button --}}
                    <div class="border-t border-slate-100 p-5 dark:border-slate-700 sm:px-6">
                        <button type="button" id="add-item"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300 dark:hover:bg-blue-500/20 dark:focus:ring-offset-slate-800 sm:w-auto">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>

                            Tambah Perangkat
                        </button>
                    </div>
                </section>

                {{-- 4. General Notes --}}
                <section
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">

                    <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-700 sm:px-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                                04
                            </span>
                            <div>
                                <h3 class="font-semibold text-slate-900 dark:text-white">
                                    Catatan Umum Pesanan
                                </h3>
                                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                    Informasi tambahan untuk keseluruhan pesanan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6">
                        <label for="general_notes"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Catatan Tambahan
                        </label>

                        <textarea id="general_notes" name="general_notes" rows="4"
                            placeholder="Catatan tambahan untuk keseluruhan pesanan (opsional)"
                            class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-500">{{ old('general_notes') }}</textarea>
                    </div>
                </section>

                {{-- Information --}}
                <div
                    class="flex gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-500/30 dark:bg-blue-500/10">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="mt-0.5 h-5 w-5 shrink-0 text-blue-600 dark:text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" />
                    </svg>

                    <p class="text-sm leading-relaxed text-blue-800 dark:text-blue-300">
                        <strong>Informasi:</strong>
                        Setelah disimpan, pesanan akan tercatat dengan status awal
                        <strong>DITERIMA</strong> untuk setiap perangkat.
                    </p>
                </div>

                {{-- Form Actions --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between">

                    <a href="{{ route('service-orders.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>

                        Simpan Pesanan Servis
                    </button>
                </div>

            </form>
        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data kontak pelanggan dari server.
                const customers = @json($customerContactData);
                const oldContactId = @json(old('contact_id'));
                const customerSelect = document.getElementById('customer_id');
                const contactSelect = document.getElementById('contact_id');
                const recipientName = document.getElementById('received_from_name');
                const recipientPhone = document.getElementById('received_from_phone');

                // Mengisi pilihan kontak berdasarkan pelanggan.
                function loadCustomerContacts() {
                    contactSelect.innerHTML =
                        '<option value="">-- Pilih kontak (opsional) --</option>';

                    const customer = customers.find(
                        item => String(item.id) === customerSelect.value
                    );

                    contactSelect.disabled = !customer || customer.contacts.length === 0;

                    if (!customer) {
                        return;
                    }

                    customer.contacts.forEach(contact => {
                        const option = document.createElement('option');

                        option.value = contact.id;
                        option.textContent = `${contact.name} - ${contact.phone}`;

                        contactSelect.appendChild(option);
                    });
                }

                customerSelect.addEventListener('change', function() {
                    loadCustomerContacts();

                    // Kontak lama tidak lagi relevan ketika pelanggan diganti.
                    contactSelect.value = '';
                });

                // Mengisi nama dan nomor penerima berdasarkan kontak terpilih.
                contactSelect.addEventListener('change', function() {
                    const customer = customers.find(
                        item => String(item.id) === customerSelect.value
                    );

                    if (!customer) return;

                    const contact = customer.contacts.find(
                        item => String(item.id) === this.value
                    );

                    if (!contact) return;

                    recipientName.value = contact.name || '';
                    recipientPhone.value = contact.phone || '';
                });

                // Mengatur input hubungan lainnya.
                const relationshipSelect = document.getElementById('received_from_relationship');
                const otherRelationshipContainer = document.getElementById('other-relationship-container');
                const otherRelationshipInput = document.getElementById('received_from_relationship_other');

                function toggleOtherRelationship() {
                    const isOther = relationshipSelect.value === 'Lainnya';

                    otherRelationshipContainer.classList.toggle('hidden', !isOther);
                    otherRelationshipInput.required = isOther;
                }

                relationshipSelect.addEventListener('change', toggleOtherRelationship);
                toggleOtherRelationship();

                // Pengelolaan daftar perangkat.
                const itemsContainer = document.getElementById('items-container');
                const addItemButton = document.getElementById('add-item');

                let itemIndex = {{ count($oldItems) }};

                const categoryOptions = `
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        `;

                function updateItemTitles() {
                    const items = itemsContainer.querySelectorAll('.device-item');

                    items.forEach((item, index) => {
                        const title = item.querySelector('.item-title');
                        title.textContent = `Perangkat ${index + 1}`;

                        const number = item.querySelector('.device-number');

                        if (number) {
                            number.textContent = String(index + 1).padStart(2, '0');
                        }

                        const removeButton = item.querySelector('.remove-item');
                        removeButton.disabled = items.length === 1;
                    });
                }

                // Menambahkan perangkat baru.
                addItemButton.addEventListener('click', function() {
                    const index = itemIndex++;

                    const itemHtml = `
                <div class="device-item overflow-hidden rounded-xl border border-slate-200 dark:border-slate-600">

                    <div class="flex items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-600 dark:bg-slate-900/50">
                        <div class="flex items-center gap-2">
                            <span class="device-number flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                                00
                            </span>
                            <strong class="item-title text-sm font-semibold text-slate-800 dark:text-slate-200">
                                Perangkat
                            </strong>
                        </div>

                        <button type="button"
                                class="remove-item rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40 dark:text-red-400 dark:hover:bg-red-500/10">
                            Hapus
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-5 p-4 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Kategori Perangkat <span class="text-red-500">*</span>
                            </label>

                            <select name="items[${index}][category_id]"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                                ${categoryOptions}
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Merek
                            </label>

                            <input type="text"
                                name="items[${index}][brand]"
                                maxlength="100"
                                placeholder="Contoh: ASUS"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Model
                            </label>

                            <input type="text"
                                name="items[${index}][model]"
                                maxlength="100"
                                placeholder="Contoh: X441U"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Nomor Seri
                            </label>

                            <input type="text"
                                name="items[${index}][serial_number]"
                                maxlength="100"
                                placeholder="Nomor seri perangkat"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Keluhan Kerusakan <span class="text-red-500">*</span>
                            </label>

                            <textarea name="items[${index}][complaint]"
                                    rows="3"
                                    required
                                    placeholder="Jelaskan keluhan yang disampaikan pelanggan"
                                    class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"></textarea>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Kondisi Fisik Awal
                            </label>

                            <textarea name="items[${index}][physical_condition]"
                                    rows="3"
                                    placeholder="Contoh: layar retak, casing lecet"
                                    class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"></textarea>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Aksesori yang Disertakan
                            </label>

                            <textarea name="items[${index}][accessories]"
                                    rows="3"
                                    placeholder="Contoh: charger, tas laptop, kabel"
                                    class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white"></textarea>
                        </div>

                    </div>
                </div>
            `;

                    itemsContainer.insertAdjacentHTML('beforeend', itemHtml);

                    updateItemTitles();

                    // Arahkan layar ke perangkat yang baru ditambahkan.
                    const newItem = itemsContainer.lastElementChild;

                    newItem.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Fokus langsung ke pilihan kategori perangkat.
                    const categorySelect = newItem.querySelector(
                        'select[name$="[category_id]"]'
                    );

                    if (categorySelect) {
                        setTimeout(() => categorySelect.focus(), 400);
                    }
                });

                // Menghapus perangkat.
                itemsContainer.addEventListener('click', function(event) {
                    const button = event.target.closest('.remove-item');

                    if (!button) return;

                    const items = itemsContainer.querySelectorAll('.device-item');

                    if (items.length <= 1) return;

                    button.closest('.device-item').remove();

                    updateItemTitles();
                });

                updateItemTitles();

                // Mengisi daftar kontak ketika halaman dikembalikan setelah validasi gagal.
                if (customerSelect.value) {
                    loadCustomerContacts();

                    if (oldContactId) {
                        contactSelect.value = String(oldContactId);
                    }
                }
            });
        </script>
    @endpush
