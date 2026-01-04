<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deisa - @yield('title', 'Health Management')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec80",
                        "background-light": "#f6f8f7",
                        "background-dark": "#102219",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a3326",
                        "text-main": "#0d1b14",
                        "text-muted": "#4c9a73",
                    },
                    fontFamily: {
                        "display": ["Manrope", "Noto Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Noto+Sans:wght@300..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 antialiased selection:bg-primary selection:text-text-main overflow-hidden">
<div class="flex h-screen flex-col">
    <!-- HEADER -->
    <header class="h-16 flex-none bg-surface-light dark:bg-surface-dark border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6 z-20 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="size-8 text-primary">
                <svg class="w-full h-full" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
                </svg>
            </div>
            <h1 class="text-xl font-bold tracking-tight text-text-main dark:text-white">Deisa</h1>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-text-main dark:text-white">Admin Kesehatan</p>
                    <p class="text-xs text-text-muted dark:text-gray-400">System Deisa</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg">
                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'A' }}
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="flex items-center justify-center h-10 w-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-text-muted hover:text-red-500 transition-colors" title="Logout">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 flex-none bg-surface-light dark:bg-surface-dark border-r border-gray-200 dark:border-gray-800 hidden lg:flex flex-col">
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }} rounded-lg font-medium transition-colors group" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Master Data</div>

                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('santri.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }} rounded-lg font-medium transition-colors group" href="{{ route('santri.index') }}">
                    <span class="material-symbols-outlined">groups</span>
                    <span>Data Santri</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('kelas.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }} rounded-lg font-medium transition-colors group" href="{{ route('kelas.index') }}">
                    <span class="material-symbols-outlined">school</span>
                    <span>Data Kelas</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('obat.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }} rounded-lg font-medium transition-colors group" href="{{ route('obat.index') }}">
                    <span class="material-symbols-outlined">medication</span>
                    <span>Data Obat</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Health Monitoring</div>

                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('sakit.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }} rounded-lg font-medium transition-colors group" href="{{ route('sakit.index') }}">
                    <span class="material-symbols-outlined">sick</span>
                    <span>Santri Sakit</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('laporan.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }} rounded-lg font-medium transition-colors group" href="{{ route('laporan.index') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                <div class="bg-gradient-to-br from-primary/20 to-primary/5 rounded-xl p-4">
                    <h4 class="font-bold text-sm text-text-main dark:text-white mb-1">Deisa</h4>
                    <p class="text-xs text-text-muted mb-3">Sistem manajemen kesehatan santri pondok pesantren.</p>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-6 lg:p-10">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <h4 class="font-bold text-red-800 dark:text-red-300 mb-2">Terjadi Kesalahan</h4>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-green-800 dark:text-green-300 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')

@stack('scripts')
</body>
</html>
