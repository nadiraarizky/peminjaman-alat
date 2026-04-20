<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sarpras App') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #fce7f3; border-radius: 10px; }

        /* --- KODE PENGHANCUR SETTINGS (JANGAN DIUBAH) --- */
        /* 1. Menghilangkan semua link yang mengandung kata profile atau settings */
        [href*="profile"], 
        [href*="settings"],
        x-dropdown-link[href*="profile"],
        .dropdown-menu a:first-child {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* 2. Menghilangkan garis pembatas yang biasanya ada di atas Logout */
        .border-t.border-gray-100, 
        .dropdown-divider,
        hr {
            display: none !important;
        }
        /* ---------------------------------------------- */
    </style>
</head>
<body class="font-sans antialiased bg-[#fdf2f8] text-gray-900"> 
    <div class="min-h-screen flex">
        @auth
        <aside class="w-72 bg-white border-r border-pink-100 flex flex-col shadow-2xl shadow-pink-200/50 sticky top-0 h-screen">
            
            <div class="p-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-500 rounded-xl flex items-center justify-center text-white shadow-lg ring-4 ring-purple-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17"></path></svg>
                    </div>
                    <span class="text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-purple-700 to-pink-600 tracking-tighter">Sarpras App</span>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar">
                @php $role = auth()->user()->role; @endphp
                
                <p class="px-5 text-[10px] font-extrabold text-pink-400 uppercase tracking-[0.2em] mb-2 mt-4">Core</p>

                @if($role === 'admin')
                    <x-nav-link-custom :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="m11 3 9 7v10h-6v-6h-4v6H4V10l9-7Z">Dashboard</x-nav-link-custom>
                    <p class="px-5 text-[10px] font-extrabold text-pink-400 uppercase tracking-[0.2em] mb-2 mt-6">Menu Utama</p>
                    <x-nav-link-custom :href="route('admin.alats.index')" :active="request()->routeIs('admin.alats.*')" icon="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2">Data Alat</x-nav-link-custom>
                    <x-nav-link-custom :href="route('admin.kategoris.index')" :active="request()->routeIs('admin.kategoris.*')" icon="M4 6h16M4 12h16M4 18h16">Kategori</x-nav-link-custom>
                    <x-nav-link-custom :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197">Data User</x-nav-link-custom>
                    <p class="px-5 text-[10px] font-extrabold text-pink-400 uppercase tracking-[0.2em] mb-2 mt-6">Transaksi</p>
                    <x-nav-link-custom :href="route('admin.peminjamans.index')" :active="request()->routeIs('admin.peminjamans.index')" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">Konfirmasi</x-nav-link-custom>
                    <x-nav-link-custom :href="route('admin.peminjamans.history')" :active="request()->routeIs('admin.peminjamans.history')" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">Riwayat Semua</x-nav-link-custom>
                @else
                    <x-nav-link-custom :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')" icon="m11 3 9 7v10h-6v-6h-4v6H4V10l9-7Z">Dashboard</x-nav-link-custom>
                    <p class="px-5 text-[10px] font-extrabold text-pink-400 uppercase tracking-[0.2em] mb-2 mt-6">Peminjaman</p>
                    <x-nav-link-custom :href="route('user.alats.index')" :active="request()->routeIs('user.alats.index')" icon="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17">Katalog Alat</x-nav-link-custom>
                    <x-nav-link-custom :href="route('user.pinjam.index')" :active="request()->routeIs('user.pinjam.index')" icon="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">Pinjaman Saya</x-nav-link-custom>
                    <x-nav-link-custom :href="route('user.pinjam.history')" :active="request()->routeIs('user.pinjam.history')" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">Riwayat Saya</x-nav-link-custom>
                @endif

                <div class="pt-4 mt-6 border-t border-pink-50">
                    <p class="px-5 text-[10px] font-extrabold text-pink-400 uppercase tracking-[0.2em] mb-2">Pengaturan</p>
                    <form action="{{ route('logout') }}" method="POST" class="mt-1">
                        @csrf
                        <button type="submit" class="group flex items-center w-full px-5 py-3 text-red-400 transition-all duration-300 rounded-xl hover:bg-red-50 hover:text-red-600">
                            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span class="ml-4 font-bold text-[11px] uppercase tracking-widest">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <div class="p-6 mt-auto">
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-[1.5rem] border border-white shadow-inner flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold shadow-md border-2 border-white flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-extrabold text-purple-900 truncate leading-none mb-1">{{ Auth::user()->name }}</p>
                        <span class="inline-block px-2 py-0.5 bg-white text-[8px] font-bold text-pink-500 rounded-md uppercase tracking-tighter">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </div>
        </aside>
        @endauth

        <main class="flex-1 min-w-0 overflow-y-auto">
            <div class="p-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>