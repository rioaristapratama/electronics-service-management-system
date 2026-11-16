@extends('layouts.app')

@section('title', 'Pesanan Servis')

@section('page-heading', 'Manajemen Pesanan Servis')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Daftar Pesanan Servis
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola penerimaan perangkat dan pesanan servis pelanggan.
                </p>
            </div>

            @can('service_orders.create')
                <a href="{{ route('service-orders.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Penerimaan Servis Baru
                </a>
            @endcan
        </div>

        {{-- Main Card --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-700 sm:px-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                            Pesanan Servis
                        </h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Informasi seluruh penerimaan perangkat servis.
                        </p>
                    </div>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('service-orders.index') }}"
                        class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">

                        <div class="relative min-w-0 flex-1 sm:min-w-64">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="7" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20 20-4-4" />
                            </svg>

                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nomor pesanan atau nama..."
                                class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-500">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="inline-flex flex-1 items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 sm:flex-none">
                                Cari
                            </button>

                            @if (request('search'))
                                <a href="{{ route('service-orders.index') }}"
                                    class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700 sm:flex-none">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-265 text-left text-sm">

                    <thead
                        class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-900/60 dark:text-slate-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold">No.</th>
                            <th class="px-5 py-4 font-semibold">Nomor Pesanan</th>
                            <th class="px-5 py-4 font-semibold">Pelanggan</th>
                            <th class="px-5 py-4 font-semibold">Diserahkan Oleh</th>
                            <th class="px-5 py-4 text-center font-semibold">Perangkat</th>
                            <th class="px-5 py-4 font-semibold">Waktu Penerimaan</th>
                            <th class="px-5 py-4 font-semibold">Petugas</th>
                            <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($serviceOrders as $index => $order)
                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-700/30">

                                {{-- Number --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-500 dark:text-slate-400">
                                    {{ $serviceOrders->firstItem() + $index }}
                                </td>

                                {{-- Order Number --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="font-semibold text-slate-900 dark:text-white">
                                        {{ $order->order_number }}
                                    </span>
                                </td>

                                {{-- Customer --}}
                                <td class="px-5 py-4">
                                    <span class="font-medium text-slate-800 dark:text-slate-200">
                                        {{ $order->customer->name }}
                                    </span>
                                </td>

                                {{-- Received From --}}
                                <td class="px-5 py-4">
                                    <div class="font-medium text-slate-800 dark:text-slate-200">
                                        {{ $order->received_from_name }}
                                    </div>

                                    @if ($order->received_from_phone)
                                        <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $order->received_from_phone }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Device Count --}}
                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                                        {{ $order->service_items_count }} perangkat
                                    </span>
                                </td>

                                {{-- Received At --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $order->received_at->format('d/m/Y H:i') }}
                                </td>

                                {{-- Officer --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $order->receivedBy->name ?? '-' }}
                                </td>

                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <a href="{{ route('service-orders.show', $order) }}"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:border-blue-300 hover:bg-blue-100 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300 dark:hover:bg-blue-500/20">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z" />
                                        </svg>

                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-16 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-700 dark:text-slate-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" />
                                            </svg>
                                        </div>

                                        <h4 class="mt-4 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            Belum ada pesanan servis
                                        </h4>

                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                            Pesanan servis yang sesuai dengan pencarian belum ditemukan.
                                        </p>

                                        @if (request('search'))
                                            <a href="{{ route('service-orders.index') }}"
                                                class="mt-4 text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                                Hapus pencarian
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($serviceOrders->hasPages())
                <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-700 sm:px-6">
                    {{ $serviceOrders->links() }}
                </div>
            @endif

            {{-- Table Footer --}}
            @if ($serviceOrders->total() > 0)
                <div class="border-t border-slate-100 px-5 py-3 dark:border-slate-700 sm:px-6">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Menampilkan
                        <span class="font-semibold text-slate-700 dark:text-slate-200">
                            {{ $serviceOrders->firstItem() }}–{{ $serviceOrders->lastItem() }}
                        </span>
                        dari
                        <span class="font-semibold text-slate-700 dark:text-slate-200">
                            {{ $serviceOrders->total() }}
                        </span>
                        pesanan servis
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection
