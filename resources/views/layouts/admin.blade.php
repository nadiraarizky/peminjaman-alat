<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>
            @if(auth()->user()->role == 'admin') Admin 
            @elseif(auth()->user()->role == 'petugas') Petugas 
            @else User @endif - Peminjaman Alat
        </title>

        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        
        {{-- SweetAlert2 Library --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #6f42c1;">
            <a class="navbar-brand ps-3" href="#">
                @if(auth()->user()->role == 'admin') Admin Peminjaman 
                @elseif(auth()->user()->role == 'petugas') Petugas Sarpras
                @else Sarpras User @endif
            </a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion" style="background-color: #ffffff; border-right: 1px solid #f8f0fc;">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading" style="color: #d63384;">Core</div>
                            <a class="nav-link" href="{{ route('home') }}" style="color: #6f42c1;">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="color: #6f42c1;"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading" style="color: #d63384;">Menu Utama</div>
                            
                            @if(auth()->user()->role == 'admin')
                                <a class="nav-link" href="{{ url('admin/alats') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tools" style="color: #6f42c1;"></i></div>
                                    Data Alat
                                </a>
                                <a class="nav-link" href="{{ route('admin.kategoris.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-list" style="color: #6f42c1;"></i></div>
                                    Kategori
                                </a>
                                <a class="nav-link" href="{{ route('admin.users.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users" style="color: #6f42c1;"></i></div>
                                    Data User
                                </a>
                                <a class="nav-link" href="{{ route('admin.peminjamans.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard-check" style="color: #6f42c1;"></i></div>
                                    Persetujuan Pinjaman
                                </a>
                                <a class="nav-link" href="{{ route('admin.peminjamans.history') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-file-invoice" style="color: #6f42c1;"></i></div>
                                    Riwayat & Laporan
                                </a>
                                <a class="nav-link" href="{{ route('admin.pengembalians.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-box-open" style="color: #6f42c1;"></i></div>
                                    Data Pengembalian
                                </a>
                                <a class="nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-history" style="color: #6f42c1;"></i></div>
                                    Log Aktivitas
                                </a>
                            @elseif(auth()->user()->role == 'petugas')
                                <a class="nav-link" href="{{ route('petugas.peminjamans.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-check-double" style="color: #6f42c1;"></i></div>
                                    Persetujuan & Pantau
                                </a>
                                <a class="nav-link" href="{{ route('petugas.peminjamans.exportPDF') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-print" style="color: #6f42c1;"></i></div>
                                    Cetak Laporan
                                </a>
                            @else
                                <a class="nav-link" href="{{ route('user.alats.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-boxes" style="color: #6f42c1;"></i></div>
                                    Katalog Alat
                                </a>
                                <a class="nav-link" href="{{ route('user.pinjam.index') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt" style="color: #6f42c1;"></i></div>
                                    Pinjaman Saya
                                </a>
                                <a class="nav-link" href="{{ route('user.pinjam.history') }}" style="color: #6f42c1;">
                                    <div class="sb-nav-link-icon"><i class="fas fa-history" style="color: #6f42c1;"></i></div>
                                    Riwayat Saya
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="sb-sidenav-footer" style="background-color: #fcfaff; color: #6f42c1; font-weight: bold;">
                        <div class="small" style="color: #d63384;">Logged in as ({{ ucfirst(auth()->user()->role) }}):</div>
                        {{ Auth::user()->name }}
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main style="background-color: #fcfaff;">
                    <div class="container-fluid px-4 pt-4">
                        @yield('content')
                    </div>
                </main>
                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>

        {{-- Script Global SweetAlert --}}
        <script>
            // Notifikasi Sukses
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            @endif

            // Notifikasi Error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#6f42c1'
                });
            @endif
        </script>

        @stack('scripts')
    </body>
</html>