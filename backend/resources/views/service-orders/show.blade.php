@extends('layouts.app')

@section('title', 'Detail Pesanan Servis')
@section('page-heading', 'Detail Pesanan Servis')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                    MENU UTAMA / PESANAN SERVIS / DETAIL
                </p>

                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Detail Pesanan Servis
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Informasi penerimaan dan perangkat yang diservis.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('service-orders.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10.5L12 3l9 7.5M5 9v11h14V9M9 20v-6h6v6" />
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>


        {{-- INFORMASI PESANAN --}}
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:px-6">
                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white">
                            Informasi Pesanan
                        </h3>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Ringkasan penerimaan perangkat dari pelanggan.
                        </p>
                    </div>

                    <span
                        class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                        {{ $serviceOrder->order_number }}
                    </span>
                </div>
            </div>

            <div class="p-5 sm:p-6">

                {{-- RINGKASAN --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/70">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Nomor Pesanan
                        </p>

                        <p class="mt-2 break-all text-base font-bold text-slate-900 dark:text-white">
                            {{ $serviceOrder->order_number }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/70">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Waktu Penerimaan
                        </p>

                        <p class="mt-2 text-base font-semibold text-slate-900 dark:text-white">
                            {{ $serviceOrder->received_at?->format('d/m/Y H:i') ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/70">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Jumlah Perangkat
                        </p>

                        <p class="mt-2 text-base font-semibold text-slate-900 dark:text-white">
                            {{ $serviceOrder->serviceItems->count() }} Perangkat
                        </p>
                    </div>

                </div>

                {{-- DETAIL PENERIMAAN --}}
                <div class="mt-6 border-t border-slate-100 pt-6 dark:border-slate-800">

                    <h4 class="mb-5 text-sm font-semibold text-slate-900 dark:text-white">
                        Informasi Penerimaan
                    </h4>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Nama Pelanggan
                            </p>

                            <p class="mt-2 font-semibold text-slate-900 dark:text-white">
                                {{ $serviceOrder->customer->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Petugas Penerima
                            </p>

                            <p class="mt-2 font-medium text-slate-900 dark:text-white">
                                {{ $serviceOrder->receivedBy?->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Diserahkan Oleh
                            </p>

                            <p class="mt-2 font-medium text-slate-900 dark:text-white">
                                {{ $serviceOrder->received_from_name ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Nomor Telepon Penyerah
                            </p>

                            <p class="mt-2 font-medium text-slate-900 dark:text-white">
                                {{ $serviceOrder->received_from_phone ?: '-' }}
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Hubungan dengan Pelanggan
                            </p>

                            <p class="mt-2 font-medium text-slate-900 dark:text-white">
                                {{ $serviceOrder->received_from_relationship ?: '-' }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- CATATAN UMUM --}}
                <div class="mt-6 border-t border-slate-100 pt-6 dark:border-slate-800">

                    <h4 class="mb-3 text-sm font-semibold text-slate-900 dark:text-white">
                        Catatan Umum
                    </h4>

                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/60">
                        <p class="whitespace-normal text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                            {{ trim($serviceOrder->general_notes ?? '') ?: 'Tidak ada catatan umum.' }}
                        </p>
                    </div>

                </div>

            </div>
        </section>


        {{-- DAFTAR PERANGKAT --}}
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div
                class="flex flex-col justify-between gap-3 border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:px-6">

                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">
                        Daftar Perangkat
                    </h3>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Informasi perangkat yang diterima untuk proses servis.
                    </p>
                </div>

                <span
                    class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                    {{ $serviceOrder->serviceItems->count() }} Perangkat
                </span>

            </div>

            <div class="space-y-8 p-5 sm:p-6">

                @forelse($serviceOrder->serviceItems as $index => $item)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700">


                        {{-- HEADER PERANGKAT --}}
                        <div
                            class="flex flex-col justify-between gap-3 border-b border-blue-800 bg-[#172554] px-4 py-4 sm:flex-row sm:items-center sm:px-5">

                            <div class="flex items-center gap-3">

                                {{-- NOMOR PERANGKAT --}}
                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-blue-400/30 bg-blue-500 text-lg font-extrabold text-white shadow-sm">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                {{-- NAMA PERANGKAT --}}
                                <div>
                                    <h4 class="text-base font-bold tracking-wide text-white">
                                        Perangkat {{ $loop->iteration }}
                                    </h4>

                                    <p class="mt-0.5 text-sm font-medium text-blue-200">
                                        {{ $item->device_name }}
                                    </p>
                                </div>

                            </div>

                            {{-- STATUS PERANGKAT --}}
                            <span
                                class="inline-flex w-fit items-center rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-bold text-white">
                                {{ $item->current_status }}
                            </span>

                        </div>

                        {{-- DETAIL PERANGKAT --}}
                        <div class="space-y-6 p-4 sm:p-5">

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                                <div>
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Kategori
                                    </p>

                                    <p class="mt-2 font-medium text-slate-900 dark:text-white">
                                        {{ $item->category?->name ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Nama Perangkat
                                    </p>

                                    <p class="mt-2 font-semibold text-slate-900 dark:text-white">
                                        {{ $item->device_name ?: '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Merek
                                    </p>

                                    <p class="mt-2 font-medium text-slate-900 dark:text-white">
                                        {{ $item->brand ?: '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Model
                                    </p>

                                    <p class="mt-2 font-medium text-slate-900 dark:text-white">
                                        {{ $item->model ?: '-' }}
                                    </p>
                                </div>

                                <div class="sm:col-span-2">
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Nomor Seri
                                    </p>

                                    <p class="mt-2 break-all font-medium text-slate-900 dark:text-white">
                                        {{ $item->serial_number ?: '-' }}
                                    </p>
                                </div>

                            </div>


                            {{-- KELUHAN --}}
                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                    </svg>

                                    <h5 class="text-sm font-semibold text-slate-900 dark:text-white">
                                        Keluhan Pelanggan
                                    </h5>
                                </div>

                                <div
                                    class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-900/60 dark:bg-amber-950/20">
                                    <p class="whitespace-normal text-sm leading-relaxed text-amber-950 dark:text-amber-200">
                                        {{ trim($item->complaint ?? '') ?: 'Tidak ada keterangan keluhan.' }}
                                    </p>
                                </div>
                            </div>


                            {{-- KONDISI DAN AKSESORI --}}
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                <div
                                    class="rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">
                                    <h4 class="mb-1 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                        Kondisi Fisik Saat Diterima
                                    </h4>
                                    <p
                                        class="m-0 whitespace-normal text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                        {{ trim($item->physical_condition ?? '') ?: 'Tidak ada keterangan.' }}</p>
                                </div>

                                <div
                                    class="rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">
                                    <h4 class="mb-1 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                        Kelengkapan / Aksesori
                                    </h4>
                                    <p
                                        class="m-0 whitespace-normal text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                        {{ trim($item->accessories ?? '') ?: 'Tidak ada keterangan.' }}</p>
                                </div>

                            </div>


                            {{-- ========================================================= --}}
                            {{-- DIAGNOSIS PERANGKAT --}}
                            {{-- ========================================================= --}}

                            @php
                                $latestEstimate = $item->estimateHistories->first();

                                $activeContacts = $serviceOrder->customer->contacts->where('is_active', true);

                                $hasNegotiated = $item->estimateHistories
                                    ->flatMap(fn($estimate) => $estimate->approvalHistories)
                                    ->contains('decision', 'MENAWAR');

                                $isNegotiation = $item->current_status === 'MENAWAR';
                            @endphp

                            <section id="diagnosis-item-{{ $item->id }}"
                                class="space-y-4 border-t border-slate-100 pt-5 dark:border-slate-700">

                                <div>
                                    <h4 class="flex items-center gap-2 font-semibold text-slate-900 dark:text-white">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                            01
                                        </span>
                                        Diagnosis Perangkat
                                    </h4>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        Hasil pemeriksaan dan tindakan yang direkomendasikan teknisi.
                                    </p>
                                </div>

                                {{-- FORM DIAGNOSIS --}}
                                @if (auth()->user()->role->permissions->contains('name', 'diagnoses.manage') &&
                                        $item->diagnoses->isEmpty() &&
                                        $item->current_status === 'DITERIMA')
                                    <form action="{{ route('service-items.diagnoses.store', $item) }}" method="POST"
                                        class="space-y-4 rounded-xl border border-blue-200 bg-blue-50/50 p-4 dark:border-blue-900/60 dark:bg-blue-950/20">

                                        @csrf

                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                Hasil Diagnosis <span class="text-red-500">*</span>
                                            </label>

                                            <textarea name="diagnosis" rows="3" required maxlength="10000"
                                                placeholder="Jelaskan hasil pemeriksaan dan kerusakan perangkat..."
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">{{ old('diagnosis') }}</textarea>

                                            @error('diagnosis')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                Tindakan yang Direkomendasikan
                                            </label>

                                            <textarea name="recommended_action" rows="3" maxlength="10000"
                                                placeholder="Jelaskan tindakan perbaikan yang disarankan..."
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">{{ old('recommended_action') }}</textarea>

                                            @error('recommended_action')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                            Simpan Diagnosis
                                        </button>
                                    </form>
                                @endif

                                {{-- RIWAYAT DIAGNOSIS --}}
                                <div class="space-y-3">

                                    <h5 class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                        Riwayat Diagnosis
                                    </h5>

                                    @forelse ($item->diagnoses as $diagnosis)
                                        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">

                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <span class="text-sm font-semibold text-slate-900 dark:text-white">
                                                    {{ $diagnosis->diagnosedBy?->name ?? 'Pengguna tidak diketahui' }}
                                                </span>

                                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ $diagnosis->diagnosed_at?->format('d/m/Y H:i') ?? '-' }}
                                                </span>
                                            </div>

                                            <div class="mt-3">
                                                <p
                                                    class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                                    Hasil Diagnosis
                                                </p>

                                                <p
                                                    class="mt-1 whitespace-normal text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                                    {{ $diagnosis->diagnosis }}
                                                </p>
                                            </div>

                                            @if ($diagnosis->recommended_action)
                                                <div class="mt-3">
                                                    <p
                                                        class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                                        Rekomendasi Tindakan
                                                    </p>

                                                    <p
                                                        class="mt-1 whitespace-normal text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                                        {{ $diagnosis->recommended_action }}
                                                    </p>
                                                </div>
                                            @endif

                                        </div>
                                    @empty
                                        <p
                                            class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            Belum ada diagnosis yang dicatat.
                                        </p>
                                    @endforelse

                                </div>

                            </section>


                            {{-- ========================================================= --}}
                            {{-- ESTIMASI BIAYA --}}
                            {{-- ========================================================= --}}

                            <section id="estimate-item-{{ $item->id }}"
                                class="space-y-4 border-t border-slate-100 pt-5 dark:border-slate-700">

                                <div>
                                    <h4 class="flex items-center gap-2 font-semibold text-slate-900 dark:text-white">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-teal-100 text-teal-700 dark:bg-teal-950 dark:text-teal-300">
                                            02
                                        </span>
                                        Estimasi Biaya Servis
                                    </h4>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        Perkiraan biaya perbaikan sebelum pengerjaan dilakukan.
                                    </p>
                                </div>

                                {{-- FORM ESTIMASI --}}
                                @if (auth()->user()->role->permissions->contains('name', 'estimates.manage') &&
                                        $item->diagnoses->isNotEmpty() &&
                                        in_array($item->current_status, ['DIAGNOSIS', 'MENAWAR'], true))
                                    <form action="{{ route('service-items.estimates.store', $item) }}" method="POST"
                                        class="space-y-4 rounded-xl border border-teal-200 bg-teal-50/50 p-4 dark:border-teal-900/60 dark:bg-teal-950/20">

                                        @csrf


                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                                            {{-- BIAYA JASA --}}
                                            <div>
                                                <label
                                                    class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                    Biaya Jasa (Rp)
                                                </label>

                                                <div class="flex items-center gap-2">
                                                    <button type="button" data-money-step="-1000"
                                                        data-money-for="labor-{{ $item->id }}"
                                                        class="flex h-11 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-slate-100 text-lg font-bold text-slate-700 hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                                        −
                                                    </button>

                                                    <input type="text" id="labor-{{ $item->id }}"
                                                        data-money-display
                                                        data-money-target="labor-raw-{{ $item->id }}"
                                                        inputmode="numeric" autocomplete="off"
                                                        value="{{ number_format((float) old('estimated_labor_cost', $isNegotiation ? $latestEstimate->estimated_labor_cost : 0), 0, ',', '.') }}"
                                                        class="min-w-0 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">

                                                    <button type="button" data-money-step="1000"
                                                        data-money-for="labor-{{ $item->id }}"
                                                        class="flex h-11 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-slate-100 text-lg font-bold text-slate-700 hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                                        +
                                                    </button>
                                                </div>

                                                <input type="hidden" name="estimated_labor_cost"
                                                    id="labor-raw-{{ $item->id }}"
                                                    value="{{ old('estimated_labor_cost', $isNegotiation ? $latestEstimate->estimated_labor_cost : 0) }}">

                                                @error('estimated_labor_cost')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- BIAYA SUKU CADANG --}}
                                            <div>
                                                <label
                                                    class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                    Biaya Suku Cadang (Rp)
                                                </label>

                                                <div class="flex items-center gap-2">
                                                    <button type="button" data-money-step="-1000"
                                                        data-money-for="parts-{{ $item->id }}"
                                                        class="flex h-11 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-slate-100 text-lg font-bold text-slate-700 hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                                        −
                                                    </button>

                                                    <input type="text" id="parts-{{ $item->id }}"
                                                        data-money-display
                                                        data-money-target="parts-raw-{{ $item->id }}"
                                                        inputmode="numeric" autocomplete="off"
                                                        value="{{ number_format((float) old('estimated_parts_cost', $isNegotiation ? $latestEstimate->estimated_parts_cost : 0), 0, ',', '.') }}"
                                                        class="min-w-0 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">

                                                    <button type="button" data-money-step="1000"
                                                        data-money-for="parts-{{ $item->id }}"
                                                        class="flex h-11 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-slate-100 text-lg font-bold text-slate-700 hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                                        +
                                                    </button>
                                                </div>

                                                <input type="hidden" name="estimated_parts_cost"
                                                    id="parts-raw-{{ $item->id }}"
                                                    value="{{ old('estimated_parts_cost', $isNegotiation ? $latestEstimate->estimated_parts_cost : 0) }}">

                                                @error('estimated_parts_cost')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- BIAYA LAINNYA --}}
                                            <div>
                                                <label
                                                    class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                    Biaya Lainnya (Rp)
                                                </label>

                                                <div class="flex items-center gap-2">
                                                    <button type="button" data-money-step="-1000"
                                                        data-money-for="other-{{ $item->id }}"
                                                        class="flex h-11 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-slate-100 text-lg font-bold text-slate-700 hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                                        −
                                                    </button>

                                                    <input type="text" id="other-{{ $item->id }}"
                                                        data-money-display
                                                        data-money-target="other-raw-{{ $item->id }}"
                                                        inputmode="numeric" autocomplete="off"
                                                        value="{{ number_format((float) old('estimated_other_cost', $isNegotiation ? $latestEstimate->estimated_other_cost : 0), 0, ',', '.') }}"
                                                        class="min-w-0 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">

                                                    <button type="button" data-money-step="1000"
                                                        data-money-for="other-{{ $item->id }}"
                                                        class="flex h-11 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-slate-100 text-lg font-bold text-slate-700 hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                                        +
                                                    </button>
                                                </div>

                                                <input type="hidden" name="estimated_other_cost"
                                                    id="other-raw-{{ $item->id }}"
                                                    value="{{ old('estimated_other_cost', $isNegotiation ? $latestEstimate->estimated_other_cost : 0) }}">

                                                @error('estimated_other_cost')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                        </div>


                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                Catatan Estimasi
                                            </label>

                                            <textarea name="notes" rows="2" maxlength="10000" placeholder="Catatan tambahan mengenai estimasi biaya..."
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">{{ old('notes') }}</textarea>

                                            @error('notes')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800">
                                            {{ $isNegotiation ? 'Simpan Estimasi Revisi' : 'Simpan Estimasi' }}
                                        </button>

                                    </form>
                                @endif


                                {{-- RIWAYAT ESTIMASI --}}
                                <div class="space-y-3">

                                    <h5 class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                        Riwayat Estimasi Biaya
                                    </h5>

                                    @forelse ($item->estimateHistories as $estimate)
                                        @php
                                            $estimateDecision = $estimate->approvalHistories
                                                ->sortByDesc('decided_at')
                                                ->first();

                                            $isNegotiated = $estimateDecision?->decision === 'MENAWAR';
                                        @endphp

                                        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">

                                            {{-- HEADER ESTIMASI --}}
                                            <div class="flex flex-wrap items-center justify-between gap-2">

                                                <span class="text-sm font-semibold text-slate-900 dark:text-white">
                                                    Estimasi oleh
                                                    {{ $estimate->recordedBy?->name ?? 'Pengguna tidak diketahui' }}
                                                </span>

                                                <div class="flex flex-wrap items-center gap-2">

                                                    @if ($isNegotiated)
                                                        <span
                                                            class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                                                            NEGOSIASI
                                                        </span>
                                                    @endif

                                                    <span class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ $estimate->estimated_at?->format('d/m/Y H:i') ?? '-' }}
                                                    </span>

                                                </div>
                                            </div>

                                            {{-- RINCIAN BIAYA --}}
                                            <div
                                                class="mt-4 space-y-2 text-sm {{ $isNegotiated ? 'opacity-60 line-through decoration-slate-500' : '' }}">

                                                <div class="flex justify-between gap-3">
                                                    <span class="text-slate-500 dark:text-slate-400">Biaya jasa</span>
                                                    <span class="font-medium text-slate-900 dark:text-white">
                                                        Rp
                                                        {{ number_format((float) $estimate->estimated_labor_cost, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                <div class="flex justify-between gap-3">
                                                    <span class="text-slate-500 dark:text-slate-400">Suku cadang</span>
                                                    <span class="font-medium text-slate-900 dark:text-white">
                                                        Rp
                                                        {{ number_format((float) $estimate->estimated_parts_cost, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                <div class="flex justify-between gap-3">
                                                    <span class="text-slate-500 dark:text-slate-400">Biaya lainnya</span>
                                                    <span class="font-medium text-slate-900 dark:text-white">
                                                        Rp
                                                        {{ number_format((float) $estimate->estimated_other_cost, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                <div
                                                    class="flex justify-between gap-3 border-t border-slate-200 pt-3 dark:border-slate-700">
                                                    <span class="font-bold text-slate-900 dark:text-white">
                                                        Total Estimasi
                                                    </span>

                                                    <span class="font-bold text-teal-700 dark:text-teal-400">
                                                        Rp
                                                        {{ number_format((float) $estimate->total_estimated_cost, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                            </div>

                                            {{-- CATATAN ESTIMASI --}}
                                            @if ($estimate->notes)
                                                <div
                                                    class="mt-3 rounded-lg bg-slate-50 p-3 dark:bg-slate-800 {{ $isNegotiated ? 'opacity-60 line-through decoration-slate-500' : '' }}">
                                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                                        Catatan
                                                    </p>

                                                    <p
                                                        class="mt-1 whitespace-normal text-sm text-slate-700 dark:text-slate-300">
                                                        {{ $estimate->notes }}
                                                    </p>
                                                </div>
                                            @endif

                                        </div>

                                    @empty
                                        <p
                                            class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            Belum ada estimasi biaya.
                                        </p>
                                    @endforelse

                                </div>

                            </section>


                            {{-- ========================================================= --}}
                            {{-- PERSETUJUAN PELANGGAN --}}
                            {{-- ========================================================= --}}

                            <section id="approval-item-{{ $item->id }}"
                                class="space-y-4 border-t border-slate-100 pt-5 dark:border-slate-700">

                                <div>
                                    <h4 class="flex items-center gap-2 font-semibold text-slate-900 dark:text-white">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                                            03
                                        </span>
                                        Persetujuan Pelanggan
                                    </h4>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        Pencatatan keputusan pelanggan terhadap estimasi biaya servis.
                                    </p>
                                </div>

                                {{-- FORM PERSETUJUAN --}}
                                @if (auth()->user()->role->permissions->contains('name', 'customer_approvals.manage') &&
                                        $item->current_status === 'MENUNGGU_PERSETUJUAN' &&
                                        $latestEstimate)
                                    <form action="{{ route('service-items.approvals.store', $item) }}" method="POST"
                                        class="space-y-4 rounded-xl border border-amber-200 bg-amber-50/50 p-4 dark:border-amber-900/60 dark:bg-amber-950/20">

                                        @csrf

                                        <input type="hidden" name="service_estimate_history_id"
                                            value="{{ $latestEstimate->id }}">

                                        <div class="rounded-lg bg-white p-3 dark:bg-slate-900">
                                            <p
                                                class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                                Estimasi yang Menunggu Persetujuan
                                            </p>

                                            <p class="mt-1 text-xl font-bold text-slate-900 dark:text-white">
                                                Rp
                                                {{ number_format((float) $latestEstimate->total_estimated_cost, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                Kontak Pelanggan
                                            </label>

                                            <select name="customer_contact_id"
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">

                                                <option value="">Tidak memilih kontak tertentu</option>

                                                @foreach ($activeContacts as $contact)
                                                    <option value="{{ $contact->id }}" @selected(old('customer_contact_id') == $contact->id)>
                                                        {{ $contact->contact_name }} - {{ $contact->phone }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('customer_contact_id')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                Keputusan Pelanggan <span class="text-red-500">*</span>
                                            </label>

                                            <select name="decision" required
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">

                                                <option value="">Pilih keputusan</option>

                                                <option value="DISETUJUI" @selected(old('decision') === 'DISETUJUI')>
                                                    Disetujui
                                                </option>

                                                @if (!$hasNegotiated)
                                                    <option value="MENAWAR" @selected(old('decision') === 'MENAWAR')>
                                                        Negosiasi (1 kali)
                                                    </option>
                                                @endif

                                                <option value="DITOLAK" @selected(old('decision') === 'DITOLAK')>
                                                    Ditolak
                                                </option>

                                            </select>

                                            @error('decision')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                Catatan Persetujuan
                                            </label>

                                            <textarea name="notes" rows="2" maxlength="10000"
                                                placeholder="Contoh: Pelanggan menyetujui perbaikan melalui WhatsApp..."
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white">{{ old('notes') }}</textarea>

                                            @error('notes')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-700">
                                            Simpan Keputusan Pelanggan
                                        </button>

                                    </form>
                                @endif


                                {{-- RIWAYAT PERSETUJUAN --}}
                                <div class="space-y-3">

                                    <h5 class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                        Riwayat Persetujuan
                                    </h5>

                                    @php
                                        $allApprovals = $item->estimateHistories
                                            ->flatMap(fn($estimate) => $estimate->approvalHistories)
                                            ->sortByDesc('decided_at');
                                    @endphp

                                    @forelse ($allApprovals as $approval)
                                        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">

                                            {{-- HEADER KEPUTUSAN --}}
                                            <div class="flex flex-wrap items-center justify-between gap-2">

                                                <span
                                                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold
                    {{ match ($approval->decision) {
                        'DISETUJUI' => 'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-300',
                        'MENAWAR' => 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
                        'DITOLAK' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                    } }}">

                                                    {{ match ($approval->decision) {
                                                        'DISETUJUI' => 'Disetujui',
                                                        'MENAWAR' => 'Negosiasi',
                                                        'DITOLAK' => 'Ditolak',
                                                        default => $approval->decision,
                                                    } }}

                                                </span>

                                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ $approval->decided_at?->format('d/m/Y H:i') ?? '-' }}
                                                </span>

                                            </div>

                                            {{-- INFORMASI PERSETUJUAN --}}
                                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">

                                                <div>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                                        Dicatat oleh
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-slate-900 dark:text-white">
                                                        {{ $approval->recordedBy?->name ?? '-' }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                                        Kontak pelanggan
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-slate-900 dark:text-white">
                                                        {{ $approval->customerContact?->contact_name ?? 'Tidak ditentukan' }}
                                                    </p>
                                                </div>

                                            </div>

                                            {{-- CATATAN --}}
                                            @if ($approval->notes)
                                                <div class="mt-3 rounded-lg bg-slate-50 p-3 dark:bg-slate-800">

                                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                                        Catatan
                                                    </p>

                                                    <p
                                                        class="mt-1 whitespace-normal text-sm text-slate-700 dark:text-slate-300">
                                                        {{ $approval->notes }}
                                                    </p>

                                                </div>
                                            @endif

                                        </div>

                                    @empty
                                        <p
                                            class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            Belum ada keputusan pelanggan.
                                        </p>
                                    @endforelse

                                </div>

                            </section>


                            {{-- WAKTU PENCATATAN --}}
                            <div
                                class="flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4 text-xs text-slate-500 dark:border-slate-700 dark:text-slate-400">

                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                </svg>

                                Dicatat pada:
                                <span class="font-medium text-slate-700 dark:text-slate-300">
                                    {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </span>

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="py-12 text-center">

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                        </div>

                        <h4 class="mt-4 font-semibold text-slate-900 dark:text-white">
                            Belum Ada Perangkat
                        </h4>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Belum ada perangkat yang tercatat dalam pesanan ini.
                        </p>

                    </div>
                @endforelse

            </div>

        </section>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const displays = document.querySelectorAll('[data-money-display]');

                function formatRupiah(value) {
                    const number = Math.max(0, Number(value) || 0);
                    return new Intl.NumberFormat('id-ID', {
                        maximumFractionDigits: 0
                    }).format(number);
                }

                function updateMoney(input, value) {
                    const number = Math.max(0, Math.floor(Number(value) || 0));
                    const target = document.getElementById(input.dataset.moneyTarget);

                    input.value = formatRupiah(number);

                    if (target) {
                        target.value = number;
                    }
                }

                displays.forEach(function(input) {
                    const target = document.getElementById(input.dataset.moneyTarget);

                    updateMoney(input, target?.value || 0);

                    input.addEventListener('input', function() {
                        const rawValue = input.value.replace(/\D/g, '');
                        updateMoney(input, rawValue);
                    });
                });

                document.querySelectorAll('[data-money-step]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const input = document.getElementById(button.dataset.moneyFor);

                        if (!input) return;

                        const target = document.getElementById(input.dataset.moneyTarget);
                        const currentValue = Number(target?.value || 0);
                        const step = Number(button.dataset.moneyStep);

                        updateMoney(input, currentValue + step);
                    });
                });
            });
        </script>
    @endpush

@endsection
