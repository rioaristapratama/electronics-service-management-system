<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - ESMS</title>

    <script>
        (() => {
            const savedTheme = localStorage.getItem('esms-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = savedTheme || (prefersDark ? 'dark' : 'light');

            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body
    class="min-h-full bg-slate-50 text-slate-800 antialiased transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">

    <div class="min-h-screen">

        {{-- Mobile Sidebar Overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden">
        </div>

        {{-- Sidebar --}}
        <aside id="app-sidebar"
            class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 dark:border-slate-800 dark:bg-slate-900 lg:translate-x-0">

            {{-- Brand --}}
            <div class="flex h-20 items-center justify-between border-b border-slate-100 px-6 dark:border-slate-800">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4L14 13l-3-3 3.7-3.7Z" />
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">
                            ESMS
                        </h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Electronics Service
                        </p>
                    </div>
                </a>

                <button id="close-sidebar" type="button"
                    class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden dark:hover:bg-slate-800"
                    aria-label="Tutup menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-6">

                <div>
                    <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Menu Utama
                    </p>

                    <div class="space-y-1">

                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                       {{ request()->routeIs('dashboard')
                           ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400'
                           : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">

                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3 10.5 12 3l9 7.5V21H3V10.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M9 21v-7h6v7" />
                            </svg>
                            Dashboard
                        </a>

                        @can('customers.view')
                            <a href="{{ route('customers.index') }}"
                                class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                           {{ request()->routeIs('customers.*')
                               ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400'
                               : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">

                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" stroke-width="1.8" />
                                    <path stroke-linecap="round" stroke-width="1.8" d="M20 8v6m3-3h-6" />
                                </svg>
                                Manajemen Pelanggan
                            </a>
                        @endcan

                        @can('service_orders.view')
                            <a href="{{ route('service-orders.index') }}"
                                class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                           {{ request()->routeIs('service-orders.*')
                               ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400'
                               : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">

                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 6h13M8 12h13M8 18h13" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 6h.01M3 12h.01M3 18h.01" />
                                </svg>
                                Pesanan Servis
                            </a>
                        @endcan

                    </div>
                </div>

                @can('users.view')
                    <div>
                        <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Administrasi
                        </p>

                        <a href="{{ route('users.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                       {{ request()->routeIs('users.*')
                           ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400'
                           : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">

                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="7" r="4" stroke-width="1.8" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M2 21v-2a7 7 0 0 1 14 0v2M19 8v6m3-3h-6" />
                            </svg>
                            Manajemen Pengguna
                        </a>
                    </div>
                @endcan

            </nav>

            {{-- Sidebar Footer --}}
            <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/70">
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                        Sistem Manajemen Servis
                    </p>
                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                        ESMS v1.0
                    </p>
                </div>
            </div>
        </aside>

        {{-- Main Area --}}
        <div class="min-h-screen lg:pl-72">

            {{-- Topbar --}}
            <header
                class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/90">
                <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

                    <div class="flex min-w-0 items-center gap-3">
                        <button id="open-sidebar" type="button"
                            class="rounded-xl border border-slate-200 p-2 text-slate-600 hover:bg-slate-100 lg:hidden dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                            aria-label="Buka menu">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div class="min-w-0">
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                                Electronics Service Management System
                            </p>
                            <h2 class="truncate text-lg font-bold text-slate-900 dark:text-white">
                                @yield('page-heading', 'Dashboard')
                            </h2>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-2 sm:gap-4">

                        {{-- Theme Toggle --}}
                        <button id="theme-toggle" type="button"
                            class="rounded-xl border border-slate-200 p-2.5 text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                            aria-label="Ganti tema" title="Ganti tema">

                            <svg id="sun-icon" class="hidden h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="4" stroke-width="1.8" />
                                <path stroke-linecap="round" stroke-width="1.8"
                                    d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
                            </svg>

                            <svg id="moon-icon" class="hidden h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M20.5 15.5A8.5 8.5 0 0 1 8.5 3.5 8.5 8.5 0 1 0 20.5 15.5Z" />
                            </svg>
                        </button>

                        {{-- User --}}
                        <div class="hidden items-center gap-3 sm:flex">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-800 dark:text-white">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ auth()->user()->role?->name ?? 'Pengguna' }}
                                </p>
                            </div>

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-red-900 dark:hover:bg-red-950/30 dark:hover:text-red-400">
                                <span class="hidden sm:inline">Keluar</span>
                                <svg class="h-5 w-5 sm:hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M10 17l5-5-5-5m5 5H3m9-9h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7" />
                                </svg>
                            </button>
                        </form>

                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

                @if (session('success'))
                    <div
                        class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m5 12 4 4L19 6" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </main>

            <footer
                class="border-t border-slate-200 px-4 py-5 text-center text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400 sm:px-6 lg:px-8">
                &copy; {{ date('Y') }} Electronics Service Management System.
                All rights reserved.
            </footer>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const html = document.documentElement;

            // Theme
            const themeToggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            function updateThemeIcons() {
                const isDark = html.classList.contains('dark');

                sunIcon.classList.toggle('hidden', !isDark);
                moonIcon.classList.toggle('hidden', isDark);
            }

            updateThemeIcons();

            themeToggle?.addEventListener('click', () => {
                const isDark = html.classList.toggle('dark');

                localStorage.setItem('esms-theme', isDark ? 'dark' : 'light');

                updateThemeIcons();
            });

            // Mobile Sidebar
            const sidebar = document.getElementById('app-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openButton = document.getElementById('open-sidebar');
            const closeButton = document.getElementById('close-sidebar');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openButton?.addEventListener('click', openSidebar);
            closeButton?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });
        });
    </script>

    @stack('scripts')

</body>

</html>
