@extends('layouts.app')

@section('title', 'Detail Pelanggan')
@section('page-heading', 'Detail Pelanggan')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                    MENU UTAMA / PELANGGAN / DETAIL
                </p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Detail Pelanggan
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Informasi lengkap pelanggan dan riwayat servis.
                </p>
            </div>

            <a href="{{ route('customers.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div
                class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300">
                <p class="font-semibold">Terjadi kesalahan:</p>
                <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ================================================= --}}
        {{-- INFORMASI PELANGGAN --}}
        {{-- ================================================= --}}
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div
                class="flex flex-col justify-between gap-3 border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:px-6">
                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">
                        Informasi Pelanggan
                    </h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Profil dan informasi dasar pelanggan.
                    </p>
                </div>

                @can('customers.manage')
                    <a href="{{ route('customers.edit', $customer) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l2.651 2.651M8 16l8.862-8.862a2.121 2.121 0 0 1 3 3L11 19H8v-3z" />
                        </svg>
                        Edit Pelanggan
                    </a>
                @endcan
            </div>

            <div class="p-5 sm:p-6">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                    <div
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-2xl font-bold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-xl font-bold text-slate-900 dark:text-white">
                            {{ $customer->name }}
                        </p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Pelanggan ESMS · ID {{ $customer->id }}
                        </p>
                    </div>
                </div>

                <div
                    class="mt-6 grid grid-cols-1 gap-5 border-t border-slate-100 pt-5 dark:border-slate-800 sm:grid-cols-2">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Nama Pelanggan
                        </p>
                        <p class="mt-2 font-medium text-slate-900 dark:text-white">
                            {{ $customer->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Tanggal Terdaftar
                        </p>
                        <p class="mt-2 font-medium text-slate-900 dark:text-white">
                            {{ $customer->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Catatan
                        </p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                            {{ $customer->notes ?: 'Tidak ada catatan.' }}
                        </p>
                    </div>

                </div>
            </div>
        </section>


        {{-- ================================================= --}}
        {{-- KONTAK PELANGGAN --}}
        {{-- ================================================= --}}
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            {{-- Section Header --}}
            <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:px-6">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white">
                            Kontak Pelanggan
                        </h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Kelola nomor telepon dan preferensi komunikasi pelanggan.
                        </p>
                    </div>

                    <span
                        class="shrink-0 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                        {{ $customer->contacts->count() }} Kontak
                    </span>
                </div>
            </div>


            {{-- TAMBAH KONTAK --}}
            @can('customers.manage')
                <div class="border-b border-slate-200 p-5 dark:border-slate-800 sm:p-6">

                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Tambah Kontak Baru
                        </h4>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Tambahkan nomor telepon atau WhatsApp pelanggan.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('customers.contacts.store', $customer) }}" class="space-y-4">

                        @csrf

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div>
                                <label for="contact_name"
                                    class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Nama Kontak
                                </label>

                                <input type="text" name="contact_name" id="contact_name" maxlength="150"
                                    value="{{ old('contact_name') }}" placeholder="Nama pemilik nomor"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:ring-blue-950">

                                @error('contact_name')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="phone" id="phone" maxlength="20" value="{{ old('phone') }}"
                                    required placeholder="Contoh: 081234567890"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:ring-blue-950">

                                @error('phone')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:gap-6">

                            <label class="flex cursor-pointer items-start gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <input type="checkbox" name="is_primary" value="1" id="new_is_primary"
                                    @checked(old('is_primary'))
                                    class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span>Jadikan kontak utama</span>
                            </label>

                            <label class="flex cursor-pointer items-start gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <input type="checkbox" name="whatsapp_consent" value="1" id="new_whatsapp_consent"
                                    @checked(old('whatsapp_consent'))
                                    class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span>Pelanggan menyetujui komunikasi WhatsApp</span>
                            </label>

                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambahkan Kontak
                            </button>
                        </div>

                    </form>
                </div>
            @endcan


            {{-- DAFTAR KONTAK --}}
            <div class="p-5 sm:p-6">
                <h4 class="mb-4 text-sm font-semibold text-slate-900 dark:text-white">
                    Daftar Kontak
                </h4>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-212.5 text-left text-sm">

                        <thead
                            class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/70 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Nama Kontak</th>
                                <th class="px-4 py-3 font-semibold">Nomor Telepon</th>
                                <th class="px-4 py-3 font-semibold">Kontak Utama</th>
                                <th class="px-4 py-3 font-semibold">WhatsApp</th>
                                <th class="px-4 py-3 font-semibold">Status</th>
                                @can('customers.manage')
                                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                            @forelse($customer->contacts as $contact)
                                <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">

                                    {{-- Nama --}}
                                    <td class="px-4 py-4 font-medium text-slate-900 dark:text-white">
                                        {{ $contact->contact_name ?: '-' }}
                                    </td>

                                    {{-- Nomor --}}
                                    <td class="px-4 py-4 text-slate-700 dark:text-slate-300">
                                        {{ $contact->phone }}
                                    </td>

                                    {{-- Kontak Utama --}}
                                    <td class="px-4 py-4">
                                        @if ($contact->is_primary)
                                            <span
                                                class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                                Utama
                                            </span>
                                        @else
                                            <span
                                                class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                                Bukan utama
                                            </span>
                                        @endif
                                    </td>

                                    {{-- WhatsApp --}}
                                    <td class="px-4 py-4">
                                        @if ($contact->whatsapp_consent)
                                            <span
                                                class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                                Disetujui
                                            </span>
                                        @else
                                            <span
                                                class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                                                Belum disetujui
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-4">
                                        @if ($contact->is_active)
                                            <span
                                                class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                                Tidak aktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- AKSI --}}
                                    @can('customers.manage')
                                        <td class="px-4 py-4">
                                            <div class="flex flex-wrap items-center justify-center gap-2">

                                                {{-- EDIT --}}
                                                <button type="button" data-edit-contact
                                                    data-update-url="{{ route('customers.contacts.update', [$customer, $contact]) }}"
                                                    data-contact-name="{{ $contact->contact_name }}"
                                                    data-phone="{{ $contact->phone }}"
                                                    data-is-primary="{{ $contact->is_primary ? '1' : '0' }}"
                                                    data-whatsapp-consent="{{ $contact->whatsapp_consent ? '1' : '0' }}"
                                                    data-is-active="{{ $contact->is_active ? '1' : '0' }}"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100 dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-300 dark:hover:bg-amber-950">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l2.651 2.651M8 16l8.862-8.862a2.121 2.121 0 0 1 3 3L11 19H8v-3z" />
                                                    </svg>
                                                    Edit
                                                </button>

                                                {{-- AKTIFKAN / NONAKTIFKAN --}}
                                                <button type="button" data-toggle-contact
                                                    data-toggle-url="{{ route('customers.contacts.toggle-status', [$customer, $contact]) }}"
                                                    data-contact-name="{{ $contact->contact_name ?: $contact->phone }}"
                                                    data-is-active="{{ $contact->is_active ? '1' : '0' }}"
                                                    class="rounded-lg border px-3 py-2 text-xs font-semibold transition
                                                {{ $contact->is_active
                                                    ? 'border-red-200 bg-red-50 text-red-700 hover:bg-red-100 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300'
                                                    : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300' }}">
                                                    {{ $contact->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>

                                            </div>
                                        </td>
                                    @endcan

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->can('customers.manage') ? 6 : 5 }}"
                                        class="px-4 py-12 text-center">

                                        <div
                                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.7">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 5h18M3 12h18M3 19h18" />
                                            </svg>
                                        </div>

                                        <p class="mt-3 font-semibold text-slate-900 dark:text-white">
                                            Belum Ada Kontak
                                        </p>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                            Belum ada informasi kontak untuk pelanggan ini.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        {{-- ================================================= --}}
        {{-- MODAL EDIT KONTAK --}}
        {{-- ================================================= --}}
        @can('customers.manage')
            <dialog id="editContactDialog" aria-labelledby="editContactTitle"
                class="m-auto max-h-[90vh] w-[calc(100%-2rem)] max-w-lg overflow-y-auto rounded-2xl border border-slate-200 bg-white p-0 text-slate-900 shadow-2xl backdrop:bg-slate-950/60 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-700">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div
                                class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l2.651 2.651M8 16l8.862-8.862a2.121 2.121 0 0 1 3 3L11 19H8v-3z" />
                                </svg>
                            </div>

                            <h3 id="editContactTitle" class="text-lg font-bold">
                                Edit Kontak
                            </h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Perbarui informasi dan preferensi kontak pelanggan.
                            </p>
                        </div>

                        <button type="button" data-close-dialog="editContactDialog" aria-label="Tutup"
                            class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800 dark:hover:text-white">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="editContactForm" method="POST" action="#" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label for="edit_contact_name"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Nama Kontak
                        </label>

                        <input type="text" name="contact_name" id="edit_contact_name" maxlength="150"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    </div>

                    <div class="mb-5">
                        <label for="edit_contact_phone"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>

                        <input type="tel" name="phone" id="edit_contact_phone" maxlength="20" required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    </div>

                    <div
                        class="space-y-4 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/60">

                        <label class="flex cursor-pointer items-start gap-3">
                            <input type="checkbox" name="is_primary" value="1" id="edit_contact_primary"
                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                            <span>
                                <span class="block text-sm font-medium text-slate-800 dark:text-slate-200">
                                    Jadikan kontak utama
                                </span>
                                <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">
                                    Kontak utama digunakan sebagai kontak prioritas pelanggan.
                                </span>
                            </span>
                        </label>

                        <div id="inactiveContactNotice"
                            class="hidden rounded-lg border border-amber-200 bg-amber-50 p-3 text-xs text-amber-800 dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-300">
                            Kontak tidak aktif tidak dapat dijadikan kontak utama.
                        </div>

                        <div class="border-t border-slate-200 dark:border-slate-700"></div>

                        <label class="flex cursor-pointer items-start gap-3">
                            <input type="checkbox" name="whatsapp_consent" value="1" id="edit_contact_whatsapp"
                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                            <span>
                                <span class="block text-sm font-medium text-slate-800 dark:text-slate-200">
                                    Persetujuan komunikasi WhatsApp
                                </span>
                                <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">
                                    Centang jika pelanggan menyetujui komunikasi melalui WhatsApp.
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" data-close-dialog="editContactDialog"
                            class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">
                            Batal
                        </button>

                        <button type="submit"
                            class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </dialog>


            {{-- ================================================= --}}
            {{-- MODAL KONFIRMASI STATUS KONTAK --}}
            {{-- ================================================= --}}
            <dialog id="contactStatusDialog" aria-labelledby="contactStatusTitle"
                class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border border-slate-200 bg-white p-0 text-slate-900 shadow-2xl backdrop:bg-slate-950/60 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                <div class="p-6">
                    <div id="statusDialogIcon"
                        class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>

                    <h3 id="contactStatusTitle" class="text-lg font-bold">
                        Konfirmasi Perubahan Status
                    </h3>

                    <p id="contactStatusMessage" class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Apakah Anda yakin ingin mengubah status kontak ini?
                    </p>

                    <form id="contactStatusForm" method="POST" action="#">
                        @csrf
                        @method('PATCH')

                        <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                            <button type="button" data-close-dialog="contactStatusDialog"
                                class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">
                                Batal
                            </button>

                            <button id="confirmStatusButton" type="submit"
                                class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                                Ya, Nonaktifkan
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endcan


        {{-- ================================================= --}}
        {{-- RIWAYAT PESANAN SERVIS --}}
        {{-- ================================================= --}}
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div
                class="flex flex-col justify-between gap-3 border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:px-6">
                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">
                        Riwayat Pesanan Servis
                    </h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Daftar pesanan servis milik pelanggan ini.
                    </p>
                </div>

                <a href="{{ route('service-orders.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50 dark:border-blue-900 dark:text-blue-300 dark:hover:bg-blue-950">
                    Semua Pesanan
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-212.5 text-left text-sm">

                    <thead
                        class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/70 dark:text-slate-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Nomor Pesanan</th>
                            <th class="px-5 py-4 font-semibold">Tanggal Diterima</th>
                            <th class="px-5 py-4 font-semibold">Petugas</th>
                            <th class="px-5 py-4 font-semibold">Jumlah Perangkat</th>
                            <th class="px-5 py-4 font-semibold">Status Perangkat</th>
                            <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($customer->serviceOrders as $order)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">

                                <td class="px-5 py-4 font-semibold text-slate-900 dark:text-white">
                                    {{ $order->order_number }}
                                </td>

                                <td class="px-5 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $order->received_at?->format('d/m/Y H:i') ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $order->receivedBy?->name ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $order->service_items_count }} perangkat
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($order->serviceItems as $item)
                                            <span
                                                class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                                {{ $item->current_status }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">-</span>
                                        @endforelse
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('service-orders.show', $order) }}"
                                        class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100 dark:bg-blue-950 dark:text-blue-300 dark:hover:bg-blue-900">
                                        Lihat Detail
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <p class="font-semibold text-slate-900 dark:text-white">
                                        Belum Ada Riwayat Servis
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        Pelanggan ini belum memiliki pesanan servis.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="border-t border-slate-100 px-5 py-3 dark:border-slate-800">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Menampilkan maksimal 10 pesanan servis terbaru milik pelanggan ini.
                </p>
            </div>

        </section>

    </div>
@endsection


{{-- ===================================================== --}}
{{-- JAVASCRIPT MODAL KONTAK --}}
{{-- ===================================================== --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Pastikan elemen modal tersedia
            const editDialog = document.getElementById('editContactDialog');
            const statusDialog = document.getElementById('contactStatusDialog');

            // ==========================================
            // EDIT KONTAK
            // ==========================================

            if (editDialog) {
                const editForm = document.getElementById('editContactForm');
                const editName = document.getElementById('edit_contact_name');
                const editPhone = document.getElementById('edit_contact_phone');
                const editPrimary = document.getElementById('edit_contact_primary');
                const editWhatsapp = document.getElementById('edit_contact_whatsapp');
                const inactiveNotice = document.getElementById('inactiveContactNotice');

                document.querySelectorAll('[data-edit-contact]').forEach(button => {
                    button.addEventListener('click', function() {

                        const isActive = this.dataset.isActive === '1';

                        editForm.action = this.dataset.updateUrl;
                        editName.value = this.dataset.contactName || '';
                        editPhone.value = this.dataset.phone || '';

                        editPrimary.checked =
                            this.dataset.isPrimary === '1' && isActive;

                        editPrimary.disabled = !isActive;

                        inactiveNotice.classList.toggle('hidden', isActive);

                        editWhatsapp.checked =
                            this.dataset.whatsappConsent === '1';

                        editDialog.showModal();
                    });
                });
            }


            // ==========================================
            // KONFIRMASI AKTIF / NONAKTIF
            // ==========================================

            if (statusDialog) {
                const statusForm = document.getElementById('contactStatusForm');
                const statusMessage = document.getElementById('contactStatusMessage');
                const statusButton = document.getElementById('confirmStatusButton');
                const statusTitle = document.getElementById('contactStatusTitle');
                const statusIcon = document.getElementById('statusDialogIcon');

                document.querySelectorAll('[data-toggle-contact]').forEach(button => {
                    button.addEventListener('click', function() {

                        const isActive = this.dataset.isActive === '1';
                        const contactName = this.dataset.contactName;

                        statusForm.action = this.dataset.toggleUrl;

                        if (isActive) {

                            statusTitle.textContent = 'Nonaktifkan Kontak?';

                            statusMessage.textContent =
                                `Apakah Anda yakin ingin menonaktifkan kontak ${contactName}? Kontak ini tidak akan lagi berstatus aktif.`;

                            statusButton.textContent = 'Ya, Nonaktifkan';

                            statusButton.className =
                                'rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700';

                            statusIcon.className =
                                'mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400';

                        } else {

                            statusTitle.textContent = 'Aktifkan Kembali Kontak?';

                            statusMessage.textContent =
                                `Apakah Anda yakin ingin mengaktifkan kembali kontak ${contactName}?`;

                            statusButton.textContent = 'Ya, Aktifkan';

                            statusButton.className =
                                'rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700';

                            statusIcon.className =
                                'mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400';
                        }

                        statusDialog.showModal();
                    });
                });
            }


            // ==========================================
            // TUTUP MODAL
            // ==========================================

            document.querySelectorAll('[data-close-dialog]').forEach(button => {

                button.addEventListener('click', function() {

                    const dialog = document.getElementById(
                        this.dataset.closeDialog
                    );

                    if (dialog && dialog.open) {
                        dialog.close();
                    }

                });

            });

        });
    </script>
@endpush
