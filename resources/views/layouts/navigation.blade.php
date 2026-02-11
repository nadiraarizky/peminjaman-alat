<div style="width: 260px; background-color: white; min-height: 100vh; font-family: 'Poppins', sans-serif; box-shadow: 2px 0 10px rgba(0,0,0,0.05); position: fixed; left: 0; top: 0; z-index: 1000;">
    
    <div style="background-color: #6d28d9; padding: 25px 20px; margin-bottom: 10px;">
        <h2 style="color: white; margin: 0; font-size: 20px; font-weight: 800; letter-spacing: 1px;">
            Sarpras App
        </h2>
    </div>

    <ul style="list-style: none; padding: 0 15px;">
        @php $role = auth()->user()->role; @endphp

        <p style="color: #ec4899; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin: 25px 0 10px 15px;">CORE</p>
        
        <li style="margin-bottom: 5px;">
            <a href="{{ $role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" 
               style="display: flex; align-items: center; padding: 12px 15px; border-radius: 12px; color: #4b5563; text-decoration: none; font-weight: 600; transition: 0.3s;"
               onmouseover="this.style.backgroundColor='#f3e8ff'; this.style.color='#6d28d9'" 
               onmouseout="this.style.backgroundColor='transparent'; this.style.color='#4b5563'">
                <span style="margin-right: 12px; font-size: 18px;">📊</span> Dashboard
            </a>
        </li>

        <p style="color: #ec4899; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin: 25px 0 10px 15px;">MENU UTAMA</p>

        @if($role === 'admin')
            <li><a href="{{ route('admin.alats.index') }}" class="sidebar-link-custom">🛠 Data Alat</a></li>
            <li><a href="{{ route('admin.kategori.index') }}" class="sidebar-link-custom">📂 Kategori</a></li>
            <li><a href="{{ route('admin.peminjamans.index') }}" class="sidebar-link-custom">📋 Data Peminjaman</a></li>
        @else
            <li><a href="{{ route('user.alats.index') }}" class="sidebar-link-custom">📦 Katalog Alat</a></li>
            <li><a href="{{ route('user.pinjam.index') }}" class="sidebar-link-custom">🔄 Pinjaman Saya</a></li>
            <li><a href="{{ route('user.pinjam.history') }}" class="sidebar-link-custom">🕒 Riwayat Saya</a></li>
        @endif

        <p style="color: #ec4899; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin: 25px 0 10px 15px;">PENGATURAN</p>
        
        <li style="margin-bottom: 5px;">
            <a href="{{ route('profile.edit') }}" class="sidebar-link-custom">
                <span style="margin-right: 12px; font-size: 18px;">👤</span> Profil Saya
            </a>
        </li>

        <li style="margin-top: 30px; padding: 0 10px;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="width: 100%; background: #fff1f2; color: #e11d48; border: none; padding: 12px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                        onmouseover="this.style.backgroundColor='#fee2e2'" 
                        onmouseout="this.style.backgroundColor='#fff1f2'">
                    🚪 LOGOUT
                </button>
            </form>
        </li>
    </ul>

    <div style="position: absolute; bottom: 20px; left: 15px; right: 15px; padding: 15px; background: #f9fafb; border-radius: 15px; border: 1px solid #f3f4f6;">
        <span style="display: block; font-size: 10px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Login Sebagai:</span>
        <span style="display: block; font-size: 14px; color: #6d28d9; font-weight: 800; text-transform: uppercase;">{{ auth()->user()->name }}</span>
    </div>
</div>

<style>
    /* Tambahan agar konten utama tidak tertutup sidebar */
    #main-content, main { 
        margin-left: 260px; 
        transition: 0.3s;
    }
    
    .sidebar-link-custom {
        display: flex; 
        align-items: center; 
        padding: 12px 15px; 
        border-radius: 12px; 
        color: #4b5563; 
        text-decoration: none; 
        font-weight: 600; 
        transition: 0.3s;
        margin-bottom: 5px;
        font-size: 14px;
    }
    .sidebar-link-custom:hover {
        background-color: #f3e8ff; 
        color: #6d28d9;
    }
</style>