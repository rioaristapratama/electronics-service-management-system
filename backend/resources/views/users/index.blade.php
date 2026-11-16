@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-heading', 'Manajemen Pengguna')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header halaman --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Daftar Pengguna
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola akun dan hak akses pengguna sistem ESMS.
                </p>
            </div>

            @if (auth()->user()->role?->name === 'Owner')
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900">
                    <span class="text-lg leading-none">+</span>
                    Tambah Pengguna
                </a>
            @endif
        </div>

        {{-- Statistik sederhana --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Total Pengguna
                </p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                    {{ $users->total() }}
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Pengguna Aktif
                </p>
                <p class="mt-2 text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                    {{ $users->getCollection()->where('is_active', true)->count() }}
                    <span class="text-xs font-normal text-slate-400">di halaman ini</span>
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Pengguna Nonaktif
                </p>
                <p class="mt-2 text-2xl font-bold text-rose-600 dark:text-rose-400">
                    {{ $users->getCollection()->where('is_active', false)->count() }}
                    <span class="text-xs font-normal text-slate-400">di halaman ini</span>
                </p>
            </div>
        </div>

        {{-- Daftar pengguna --}}
        <div
            class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

            {{-- Search --}}
            <div class="border-b border-slate-200 p-4 dark:border-slate-700 sm:p-5">
                <form method="GET" action="{{ route('users.index') }}"
                    class="flex flex-col gap-3 sm:flex-row sm:items-center">

                    <div class="relative w-full sm:max-w-md">
                        <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Cari
                        </button>

                        @if (request()->filled('search'))
                            <a href="{{ route('users.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-225 text-left text-sm">
                    <thead
                        class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:bg-slate-800/70 dark:text-slate-400">
                        <tr>
                            <th class="px-5 py-4">No.</th>
                            <th class="px-5 py-4">Nama Pengguna</th>
                            <th class="px-5 py-4">Email</th>
                            <th class="px-5 py-4">Telepon</th>
                            <th class="px-5 py-4">Role</th>
                            <th class="px-5 py-4">Status</th>
                            @if (auth()->user()->role?->name === 'Owner')
                                <th class="px-5 py-4 text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($users as $index => $user)
                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/50">

                                <td class="px-5 py-4 text-slate-500 dark:text-slate-400">
                                    {{ $users->firstItem() + $index }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <span class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $user->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $user->email }}
                                </td>

                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $user->phone ?? '-' }}
                                </td>

                                <td class="px-5 py-4">
                                    @php
                                        $roleName = $user->role?->name ?? '-';
                                        $roleClass = match ($roleName) {
                                            'Owner'
                                                => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                                            'Admin'
                                                => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                                            'Technician'
                                                => 'bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300',
                                            default
                                                => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleClass }}">
                                        {{ $roleName }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($user->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-900/40 dark:text-rose-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                @if (auth()->user()->role?->name === 'Owner')
                                    <td class="px-5 py-4 text-center">
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100 dark:border-amber-700 dark:bg-amber-900/20 dark:text-amber-300 dark:hover:bg-amber-900/40">
                                            Edit
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role?->name === 'Owner' ? 7 : 6 }}"
                                    class="px-5 py-14 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="mb-3 h-12 w-12 text-slate-300 dark:text-slate-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 0 0-5.196-2.034M17 20H7m10 0v-2c0-.653-.124-1.277-.35-1.85M7 20H2v-2a3 3 0 0 1 5.196-2.034M7 20v-2c0-.653.124-1.277.35-1.85m0 0a5.002 5.002 0 0 1 9.3 0M15 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM7 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                        </svg>

                                        <p class="font-semibold text-slate-700 dark:text-slate-200">
                                            Belum ada pengguna ditemukan.
                                        </p>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                            Coba gunakan kata kunci pencarian yang berbeda.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-700">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif

            {{-- Footer --}}
            <div class="border-t border-slate-100 px-5 py-3 dark:border-slate-700">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}
                    dari {{ $users->total() }} pengguna.
                </p>
            </div>
        </div>
    </div>
@endsection
