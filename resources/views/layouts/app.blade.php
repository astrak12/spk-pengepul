<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SPK Pengepul') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-green-800 text-white flex flex-col shadow-xl">
            <div class="h-16 flex items-center justify-center border-b border-green-700 bg-green-900">
                <h1 class="text-xl font-bold uppercase tracking-widest text-white">SPK Bank Sampah</h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Dashboard</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-xs font-bold text-green-300 uppercase tracking-wider">Master Data</p>
                </div>

                @if(Auth::user()->role == 'admin')
                <a href="{{ route('user.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('user.*') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Manajemen Pengguna</span>
                </a>
                @endif
                
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'pimpinan')
                <a href="{{ route('log.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('log.*') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Log Aktivitas</span>
                </a>
                @endif

                <a href="{{ route('kriteria.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('kriteria.*') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Data Kriteria</span>
                </a>

                <a href="{{ route('alternatif.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('alternatif.*') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Data Alternatif</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-xs font-bold text-green-300 uppercase tracking-wider">Proses SPK</p>
                </div>

                <a href="{{ route('penilaian.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('penilaian.*') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Penilaian</span>
                </a>

                <a href="{{ route('hasil.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('hasil.index') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Hasil Keputusan</span>
                </a>
                
                <a href="{{ route('hasil.sensitivitas') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('hasil.sensitivitas') ? 'bg-green-600 text-white font-bold shadow-lg' : 'text-green-100 hover:bg-green-700 hover:text-white' }} rounded-lg transition-colors">
                    <span>Uji Sensitivitas</span>
                </a>
                
            </nav>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
            
            <header class="h-16 bg-white shadow flex items-center justify-between px-6 z-10 border-b-2 border-green-600">
                <div class="font-semibold text-gray-700">
                    @if (isset($header))
                        {{ $header }}
                    @endif
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">Halo, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm px-3 py-1 bg-red-100 text-red-600 font-bold rounded hover:bg-red-200 transition">
                            Log Out
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>
</html>