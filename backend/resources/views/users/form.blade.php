@extends('layouts.app')

@section('title', $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('page-heading', $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">

        {{-- Header --}}
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                {{ $isEdit ? 'Edit Informasi Pengguna' : 'Tambah Pengguna Baru' }}
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ $isEdit ? 'Perbarui informasi akun dan hak akses pengguna.' : 'Buat akun baru untuk pengguna sistem ESMS.' }}
            </p>
        </div>

        {{-- Form Card --}}
        <div
            class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m12-13a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm4 3v6m3-3h-6" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white">
                            Informasi Akun
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Lengkapi informasi pengguna di bawah ini.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-6">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div
                        class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 dark:border-rose-800 dark:bg-rose-900/20">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600 dark:text-rose-400"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                            </svg>

                            <div>
                                <p class="text-sm font-semibold text-rose-800 dark:text-rose-300">
                                    Terdapat kesalahan pada formulir.
                                </p>

                                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700 dark:text-rose-300">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}"
                    class="space-y-6">

                    @csrf

                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    {{-- Section 01: Personal Information --}}
                    <section class="space-y-4">
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                01. Informasi Pengguna
                            </h4>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                Identitas dasar pengguna sistem.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Name --}}
                            <div class="sm:col-span-2">
                                <label for="name"
                                    class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Nama Lengkap
                                    <span class="text-rose-500">*</span>
                                </label>

                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    placeholder="Masukkan nama lengkap" required autocomplete="name"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email"
                                    class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Email
                                    <span class="text-rose-500">*</span>
                                </label>

                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    placeholder="nama@email.com" required autocomplete="email"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone"
                                    class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Nomor Telepon
                                </label>

                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="Contoh: 081234567890" autocomplete="tel"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">
                            </div>
                        </div>
                    </section>

                    <div class="border-t border-slate-100 dark:border-slate-700"></div>

                    {{-- Section 02: Access --}}
                    <section class="space-y-4">
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                02. Hak Akses
                            </h4>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                Tentukan peran dan status akun pengguna.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Role --}}
                            <div>
                                <label for="role_id"
                                    class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Role Pengguna
                                    <span class="text-rose-500">*</span>
                                </label>

                                <select id="role_id" name="role_id" required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">

                                    <option value="">Pilih role</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Account Status --}}
                            <div>
                                <label for="is_active"
                                    class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Status Akun
                                    <span class="text-rose-500">*</span>
                                </label>

                                <select id="is_active" name="is_active" required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">

                                    <option value="1" @selected(old('is_active', $user->exists ? (int) $user->is_active : 1) == 1)>
                                        Aktif
                                    </option>

                                    <option value="0" @selected(old('is_active', $user->exists ? (int) $user->is_active : 1) == 0)>
                                        Nonaktif
                                    </option>
                                </select>
                            </div>
                        </div>
                    </section>

                    <div class="border-t border-slate-100 dark:border-slate-700"></div>

                    {{-- Section 03: Password --}}
                    <section class="space-y-4">
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                03. Keamanan Akun
                            </h4>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                {{ $isEdit ? 'Kosongkan password jika tidak ingin mengubahnya.' : 'Buat password untuk akun pengguna baru.' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Password --}}
                            <div>
                                <label for="password"
                                    class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Password
                                    @unless ($isEdit)
                                        <span class="text-rose-500">*</span>
                                    @endunless
                                </label>

                                <input type="password" id="password" name="password"
                                    autocomplete="{{ $isEdit ? 'new-password' : 'new-password' }}"
                                    {{ $isEdit ? '' : 'required' }} placeholder="Masukkan password"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">
                            </div>

                            {{-- Password Confirmation --}}
                            <div>
                                <label for="password_confirmation"
                                    class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Konfirmasi Password
                                    @unless ($isEdit)
                                        <span class="text-rose-500">*</span>
                                    @endunless
                                </label>

                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    autocomplete="new-password" {{ $isEdit ? '' : 'required' }}
                                    placeholder="Ulangi password"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-900">
                            </div>
                        </div>

                        @if ($isEdit)
                            <div
                                class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 dark:border-blue-800 dark:bg-blue-900/20">
                                <p class="text-xs leading-relaxed text-blue-800 dark:text-blue-300">
                                    Informasi: Password lama akan tetap digunakan jika kedua kolom password dikosongkan.
                                </p>
                            </div>
                        @endif
                    </section>

                    {{-- Actions --}}
                    <div
                        class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 dark:border-slate-700 sm:flex-row sm:justify-end">

                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            Kembali
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>

                            {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Pengguna' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 dark:text-slate-500">
            Pastikan informasi dan hak akses pengguna sudah benar sebelum menyimpan.
        </p>
    </div>
@endsection
