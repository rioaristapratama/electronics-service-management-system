<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#172554">

    <title>Login - Electronics Service Management System</title>

    <script>
        (() => {
            const savedTheme = localStorage.getItem('esms-theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = savedTheme || (systemDark ? 'dark' : 'light');

            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-full bg-slate-100 text-slate-800 antialiased transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">

    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6">

        {{-- Background Decoration --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-blue-200/40 blur-3xl dark:bg-blue-900/20">
            </div>
            <div
                class="absolute -bottom-40 -right-32 h-96 w-96 rounded-full bg-teal-200/40 blur-3xl dark:bg-teal-900/20">
            </div>

            <div class="absolute inset-0 opacity-[0.025] dark:opacity-[0.04]"
                style="background-image: radial-gradient(#64748b 1px, transparent 1px); background-size: 24px 24px;">
            </div>
        </div>

        {{-- Theme Toggle --}}
        <button type="button" id="theme-toggle" aria-label="Ganti tema"
            class="absolute right-5 top-5 z-10 flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 sm:right-8 sm:top-8">

            <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36-6.36-1.42 1.42M7.06 16.94l-1.42 1.42m12.72 0-1.42-1.42M7.06 7.06 5.64 5.64M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
            </svg>

            <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M20.5 14.5A8.5 8.5 0 0 1 9.5 3.5a8.5 8.5 0 1 0 11 11Z" />
            </svg>
        </button>

        {{-- Login Container --}}
        <div class="relative z-10 w-full max-w-md">

            {{-- Brand --}}
            <div class="mb-8 text-center">
                <div
                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-linear-to-br from-blue-600 to-blue-800 text-white shadow-lg shadow-blue-600/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                            d="M9 3h6m-5 0v4.5L5.5 18a2 2 0 0 0 1.8 3h9.4a2 2 0 0 0 1.8-3L14 7.5V3m-5 11h6m-8 4h10" />
                    </svg>
                </div>

                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Electronics Service
                </h1>

                <p class="mt-1 text-sm font-medium tracking-wide text-blue-600 dark:text-blue-400">
                    MANAGEMENT SYSTEM
                </p>
            </div>

            {{-- Login Card --}}
            <div
                class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xl shadow-slate-900/5 dark:border-slate-800 dark:bg-slate-900 dark:shadow-black/20">

                <div class="p-6 sm:p-8">

                    {{-- Heading --}}
                    <div class="mb-7">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                            Selamat Datang
                        </h2>

                        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                            Silakan masuk menggunakan akun ESMS Anda.
                        </p>
                    </div>

                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div
                            class="mb-5 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 dark:border-rose-800 dark:bg-rose-900/20">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="mt-0.5 h-5 w-5 shrink-0 text-rose-600 dark:text-rose-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                            </svg>

                            <p class="text-sm text-rose-700 dark:text-rose-300">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email"
                                class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Email
                            </label>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 7l9 6 9-6M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z" />
                                    </svg>
                                </div>

                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="nama@email.com" autocomplete="username" required autofocus
                                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:bg-slate-800 dark:focus:ring-blue-900/40">
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password"
                                    class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    Password
                                </label>
                            </div>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M7 10V7a5 5 0 0 1 10 0v3m-11 0h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2Zm5 5v3" />
                                    </svg>
                                </div>

                                <input type="password" name="password" id="password" placeholder="Masukkan password"
                                    autocomplete="current-password" required
                                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400 dark:focus:bg-slate-800 dark:focus:ring-blue-900/40">

                                <button type="button" id="toggle-password" aria-label="Tampilkan password"
                                    class="absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400 transition hover:text-slate-600 dark:hover:text-slate-200">

                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Zm9.5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    </svg>

                                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8M9.9 5.2A10.5 10.5 0 0 1 12 5c6 0 9.5 7 9.5 7a16 16 0 0 1-3.1 3.8M6.2 6.2C3.8 8 2.5 12 2.5 12s3.5 7 9.5 7c1.2 0 2.3-.3 3.3-.7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center justify-between">
                            <label for="remember"
                                class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-600 dark:text-slate-400">

                                <input type="checkbox" name="remember" id="remember" value="1"
                                    @checked(old('remember'))
                                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800">

                                Ingat saya
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 hover:shadow-blue-600/30 focus:outline-none focus:ring-4 focus:ring-blue-200 active:scale-[0.99] dark:focus:ring-blue-900">

                            Masuk ke Sistem

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14m-7-7 7 7-7 7" />
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Card Footer --}}
                <div
                    class="border-t border-slate-100 bg-slate-50/80 px-6 py-4 text-center dark:border-slate-800 dark:bg-slate-800/40">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Sistem Manajemen Layanan Servis Elektronik
                    </p>
                </div>
            </div>

            {{-- Page Footer --}}
            <p class="mt-7 text-center text-xs text-slate-400 dark:text-slate-500">
                &copy; {{ date('Y') }} Electronics Service Management System.
                All rights reserved.
            </p>
        </div>
    </main>

    {{-- Interactive Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Theme Toggle
            const themeToggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            function updateThemeIcon() {
                const isDark = document.documentElement.classList.contains('dark');

                sunIcon.classList.toggle('hidden', !isDark);
                moonIcon.classList.toggle('hidden', isDark);
            }

            updateThemeIcon();

            themeToggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');

                localStorage.setItem('esms-theme', isDark ? 'dark' : 'light');

                updateThemeIcon();
            });

            // Password Visibility
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            togglePassword.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';

                passwordInput.type = isPassword ? 'text' : 'password';

                eyeIcon.classList.toggle('hidden', isPassword);
                eyeOffIcon.classList.toggle('hidden', !isPassword);

                togglePassword.setAttribute(
                    'aria-label',
                    isPassword ? 'Sembunyikan password' : 'Tampilkan password'
                );
            });
        });
    </script>

</body>

</html>
