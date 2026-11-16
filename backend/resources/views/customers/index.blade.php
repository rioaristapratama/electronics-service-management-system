@extends('layouts.app')

@section('title', 'Manajemen Pelanggan')
@section('page-heading', 'Manajemen Pelanggan')

@section('content')
    <div class="space-y-6">

        {{-- Page Introduction --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                    MENU UTAMA / PELANGGAN
                </p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Manajemen Pelanggan
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola data pelanggan dan informasi kontak.
                </p>
            </div>

            @can('customers.manage')
                <a href="{{ route('customers.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pelanggan
                </a>
            @endcan
        </div>

        {{-- Success Notification --}}
        @if (session('success'))
            <div
                class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Customer Table Card --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:px-6">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                            Daftar Pelanggan
                        </h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Informasi pelanggan yang terdaftar dalam sistem.
                        </p>
                    </div>

                    <span
                        class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                        {{ $customers->total() }} Pelanggan
                    </span>
                </div>
            </div>

            {{-- Search --}}
            <div
                class="flex flex-col gap-3 border-b border-slate-200 p-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <form method="GET" action="{{ route('customers.index') }}"
                    class="flex w-full flex-col gap-2 sm:max-w-lg sm:flex-row">

                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path stroke-linecap="round" d="m20 20-4-4" />
                        </svg>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau nomor telepon..."
                            class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-950">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 dark:bg-blue-600 dark:hover:bg-blue-700 sm:flex-none">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('customers.index') }}"
                                class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 sm:flex-none">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Responsive Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-262.5 text-left text-sm">
                    <thead
                        class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/70 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4 font-semibold">No.</th>
                            <th class="px-6 py-4 font-semibold">Nama Pelanggan</th>
                            <th class="px-6 py-4 text-center font-semibold">Jumlah Kontak</th>
                            <th class="px-6 py-4 text-center font-semibold">Pesanan Servis</th>
                            <th class="px-6 py-4 font-semibold">Terdaftar</th>
                            <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($customers as $index => $customer)
                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">

                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                                    {{ $customers->firstItem() + $index }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-slate-900 dark:text-white">
                                                {{ $customer->name }}
                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                ID: {{ $customer->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex min-w-8 items-center justify-center rounded-lg bg-slate-100 px-2.5 py-1 font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $customer->contacts_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex min-w-8 items-center justify-center rounded-lg bg-blue-50 px-2.5 py-1 font-medium text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                        {{ $customer->service_orders_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $customer->created_at->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('customers.show', $customer) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 dark:border-slate-700 dark:text-slate-300 dark:hover:border-blue-800 dark:hover:bg-blue-950 dark:hover:text-blue-300">
                                            Detail
                                        </a>

                                        @can('customers.manage')
                                            <a href="{{ route('customers.edit', $customer) }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-100 dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-300 dark:hover:bg-amber-950">
                                                Edit
                                            </a>
                                        @endcan
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.7">
                                            <circle cx="9" cy="8" r="3" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 20v-1a6 6 0 0 1 12 0v1M16 11a3 3 0 1 0 0-6m2 9a5 5 0 0 1 3 5v1" />
                                        </svg>
                                    </div>

                                    <h4 class="mt-4 font-semibold text-slate-900 dark:text-white">
                                        Belum Ada Pelanggan
                                    </h4>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        @if (request('search'))
                                            Tidak ditemukan pelanggan dengan kata kunci tersebut.
                                        @else
                                            Data pelanggan belum tersedia di dalam sistem.
                                        @endif
                                    </p>

                                    @if (request('search'))
                                        <a href="{{ route('customers.index') }}"
                                            class="mt-3 inline-block text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                            Hapus pencarian
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            @if ($customers->hasPages())
                <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-800 sm:px-6">
                    {{ $customers->appends(request()->query())->links() }}
                </div>
            @endif

            {{-- Table Footer --}}
            @if ($customers->total() > 0)
                <div class="border-t border-slate-100 px-5 py-3 dark:border-slate-800 sm:px-6">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Menampilkan
                        <span class="font-semibold text-slate-700 dark:text-slate-300">
                            {{ $customers->firstItem() }}–{{ $customers->lastItem() }}
                        </span>
                        dari
                        <span class="font-semibold text-slate-700 dark:text-slate-300">
                            {{ $customers->total() }}
                        </span>
                        pelanggan
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection
