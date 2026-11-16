@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@section('content')

    <div class="mb-8">
        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
            OVERVIEW
        </p>

        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
            Selamat datang, {{ auth()->user()->name }}!
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Kelola operasional layanan servis elektronik melalui satu sistem terintegrasi.
        </p>
    </div>

    {{-- Quick Access --}}
    <div class="mb-8">
        <div class="mb-4">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                Akses Cepat
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Pilih modul yang ingin kamu kelola.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            @can('customers.view')
                <a href="{{ route('customers.index') }}"
                    class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-300 hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:hover:border-blue-700">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/10 dark:text-blue-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" stroke-width="1.8" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 8v6m3-3h-6" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-slate-900 dark:text-white">
                        Manajemen Pelanggan
                    </h3>

                    <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                        Kelola data pelanggan, kontak, dan riwayat layanan servis.
                    </p>

                    <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400">
                        Buka Modul
                        <span class="transition group-hover:translate-x-1">&rarr;</span>
                    </div>
                </a>
            @endcan

            @can('service_orders.view')
                <a href="{{ route('service-orders.index') }}"
                    class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-teal-300 hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:hover:border-teal-700">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600 transition group-hover:bg-teal-600 group-hover:text-white dark:bg-teal-500/10 dark:text-teal-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M8 6h13M8 12h13M8 18h13" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 6h.01M3 12h.01M3 18h.01" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-slate-900 dark:text-white">
                        Pesanan Servis
                    </h3>

                    <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                        Pantau penerimaan perangkat dan informasi pesanan servis.
                    </p>

                    <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-teal-600 dark:text-teal-400">
                        Buka Modul
                        <span class="transition group-hover:translate-x-1">&rarr;</span>
                    </div>
                </a>
            @endcan

            @can('users.view')
                <a href="{{ route('users.index') }}"
                    class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-violet-300 hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:hover:border-violet-700">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 transition group-hover:bg-violet-600 group-hover:text-white dark:bg-violet-500/10 dark:text-violet-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="9" cy="7" r="4" stroke-width="1.8" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M2 21v-2a7 7 0 0 1 14 0v2M19 8v6m3-3h-6" />
                        </svg>
                    </div>

                    <h3 class="mt-5 font-semibold text-slate-900 dark:text-white">
                        Manajemen Pengguna
                    </h3>

                    <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                        Kelola akun pengguna dan akses sistem sesuai kewenangan.
                    </p>

                    <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-violet-600 dark:text-violet-400">
                        Buka Modul
                        <span class="transition group-hover:translate-x-1">&rarr;</span>
                    </div>
                </a>
            @endcan

        </div>
    </div>

    {{-- Account Information --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

        <div class="flex items-center gap-3">
            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" stroke-width="1.8" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 21a8 8 0 0 1 16 0" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-slate-900 dark:text-white">
                    Informasi Akun
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Informasi pengguna yang sedang masuk.
                </p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-5 border-t border-slate-100 pt-5 sm:grid-cols-3 dark:border-slate-800">

            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                    Nama Pengguna
                </p>
                <p class="mt-2 wrap-break-words text-sm font-semibold text-slate-800 dark:text-slate-200">
                    {{ auth()->user()->name }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                    Email
                </p>
                <p class="mt-2 break-all text-sm font-semibold text-slate-800 dark:text-slate-200">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                    Role
                </p>
                <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-200">
                    {{ auth()->user()->role?->name ?? 'Belum ditentukan' }}
                </p>
            </div>

        </div>
    </div>

@endsection
