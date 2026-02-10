<ul>
    @php $role = auth()->user()->role; @endphp

    @if($role === 'admin')
        <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
        <li><a href="{{ route('admin.alats.index') }}">Kelola Alat</a></li>
        <li><a href="{{ route('admin.settings') }}">Settings</a></li>

    @elseif($role === 'user')
        <li><a href="{{ route('user.dashboard') }}">Dashboard User</a></li>
        <li><a href="{{ route('user.peminjaman') }}">Peminjaman Alat</a></li>
        <li><a href="{{ route('user.account') }}">Account</a></li>
    @endif

    <li><a href="{{ route('profile.edit') }}">Edit Profile</a></li>

    <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </li>
</ul>
