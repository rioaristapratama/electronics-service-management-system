@extends('layouts.app')

@section('title', $isEdit ? 'Edit Pelanggan' : 'Tambah Pelanggan')
@section('page-heading', $isEdit ? 'Edit Data Pelanggan' : 'Tambah Pelanggan')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Informasi halaman --}}
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ $isEdit ? 'Perbarui informasi identitas pelanggan.' : 'Daftarkan pelanggan baru beserta kontak pertamanya.' }}
            </p>
        </div>

        {{-- Form pelanggan --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

            {{-- Header --}}
            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19a6 6 0 00-12 0m12 0h6v-1a4 4 0 00-4-4m-8-3a4 4 0 100-8 4 4 0 000 8zm8-1a4 4 0 10-2-7.464" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                            {{ $isEdit ? 'Edit Data Pelanggan' : 'Data Pelanggan Baru' }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Lengkapi informasi di bawah ini dengan benar.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">

                {{-- Validasi --}}
                @if ($errors->any())
                    <div
                        class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900/60 dark:bg-red-950/30">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="mt-0.5 h-5 w-5 shrink-0 text-red-600 dark:text-red-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>

                            <div>
                                <p class="font-semibold text-red-800 dark:text-red-300">
                                    Periksa kembali data yang dimasukkan.
                                </p>
                                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-400">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST"
                    action="{{ $isEdit ? route('customers.update', $customer) : route('customers.store') }}"
                    class="space-y-8">
                    @csrf

                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    {{-- Informasi pelanggan --}}
                    <section>
                        <div class="mb-5">
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                                Informasi Pelanggan
                            </h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Informasi dasar identitas pelanggan.
                            </p>
                        </div>

                        <div class="space-y-5">

                            {{-- Nama --}}
                            <div>
                                <label for="name"
                                    class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Nama Pelanggan <span class="text-red-500">*</span>
                                </label>

                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $customer->name) }}" maxlength="150"
                                    placeholder="Masukkan nama pelanggan" required autofocus
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500">

                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <label for="notes"
                                    class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Catatan
                                    <span class="font-normal text-slate-400">(Opsional)</span>
                                </label>

                                <textarea id="notes" name="notes" rows="4" maxlength="5000"
                                    placeholder="Tambahkan informasi atau catatan mengenai pelanggan..."
                                    class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500">{{ old('notes', $customer->notes) }}</textarea>

                                <p class="mt-2 text-xs text-slate-400">
                                    Maksimal 5.000 karakter.
                                </p>

                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </section>

                    {{-- Kontak pertama hanya untuk pelanggan baru --}}
                    @unless ($isEdit)
                        <section class="border-t border-slate-200 pt-7 dark:border-slate-700">

                            <div class="mb-5">
                                <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                                    Kontak Pelanggan
                                </h3>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Kontak pertama otomatis menjadi kontak utama pelanggan.
                                </p>
                            </div>

                            <div class="space-y-5">

                                {{-- Nama kontak --}}
                                <div>
                                    <label for="contact_name"
                                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Nama Kontak
                                        <span class="font-normal text-slate-400">(Opsional)</span>
                                    </label>

                                    <input type="text" id="contact_name" name="contact_name"
                                        value="{{ old('contact_name') }}" maxlength="150"
                                        placeholder="Nama pemilik nomor telepon"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500">

                                    @error('contact_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nomor telepon --}}
                                <div>
                                    <label for="phone"
                                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Nomor Telepon / WhatsApp <span class="text-red-500">*</span>
                                    </label>

                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                        maxlength="20" placeholder="Contoh: 081234567890" required
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500">

                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Persetujuan WhatsApp --}}
                                <div
                                    class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/60">
                                    <label for="whatsapp_consent" class="flex cursor-pointer items-start gap-3">
                                        <input type="checkbox" id="whatsapp_consent" name="whatsapp_consent" value="1"
                                            @checked(old('whatsapp_consent'))
                                            class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700">

                                        <span>
                                            <span class="block text-sm font-medium text-slate-800 dark:text-slate-200">
                                                Pelanggan menyetujui komunikasi melalui WhatsApp
                                            </span>
                                            <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">
                                                Centang hanya jika pelanggan telah memberikan persetujuan.
                                            </span>
                                        </span>
                                    </label>

                                    @error('whatsapp_consent')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </section>
                    @endunless

                    {{-- Tombol aksi --}}
                    <div
                        class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between">

                        <a href="{{ $isEdit ? route('customers.show', $customer) : route('customers.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Batal
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pelanggan' }}
                        </button>

                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
