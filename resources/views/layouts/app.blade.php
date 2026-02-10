<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        <!-- Sidebar -->
        @auth
        <aside class="bg-white w-64 min-h-screen p-4 shadow">
            @php $role = auth()->user()->role; @endphp
            <ul class="space-y-2">
                @if($role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Dashboard Admin</a></li>
                    <li><a href="{{ route('admin.alats.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Kelola Alat</a></li>
                    <li><a href="{{ route('admin.settings') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Settings</a></li>
                @elseif($role === 'user')
                    <li><a href="{{ route('user.dashboard') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Dashboard User</a></li>
                    <li><a href="{{ route('user.peminjaman') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Peminjaman Alat</a></li>
                    <li><a href="{{ route('user.account') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Account</a></li>
                @endif
                <li><a href="{{ route('profile.edit') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Edit Profile</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-2 py-1 hover:bg-gray-200 rounded">Logout</button>
                    </form>
                </li>
            </ul>
        </aside>
        @endauth

        <!-- Page Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

    </div>
</body>
</html>
