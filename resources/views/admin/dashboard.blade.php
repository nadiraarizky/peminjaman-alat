@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Judul Dinamis: Muncul "Admin" atau "Petugas" sesuai Role --}}
    <h1 class="mt-4" style="color: #6f42c1; font-weight: 800;">Dashboard {{ auth()->user()->role == 'admin' ? 'Admin' : 'Petugas' }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384; font-weight: 500;">Selamat Datang, {{ Auth::user()->name }}!</li>
    </ol>

    <div class="row">
        {{-- Card Total Alat (Warna Ungu) --}}
        <div class="col-xl-4 col-md-6">
            <div class="card text-white mb-4 shadow-sm" style="background-color: #6f42c1; border: none; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-white-50 fw-bold">Total Alat Terdaftar</div>
                            <h2 class="fw-bold mb-0">{{ $totalAlat }}</h2>
                        </div>
                        <i class="fas fa-boxes fa-2x text-white-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1); border: none;">
                    {{-- Menggunakan route name admin.alats.index --}}
                    <a class="small text-white stretched-link" href="{{ route('admin.alats.index') }}">Lihat Detail Alat</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        {{-- Card Total Denda (Warna Pink) --}}
        <div class="col-xl-4 col-md-6">
            <div class="card text-white mb-4 shadow-sm" style="background-color: #d63384; border: none; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-white-50 fw-bold">Total Denda Seluruh User</div>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
                        </div>
                        <i class="fas fa-money-bill-wave fa-2x text-white-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1); border: none;">
                    {{-- PERBAIKAN: Menggunakan route name admin.peminjamans.history agar tidak 404 --}}
                    <a class="small text-white stretched-link" href="{{ route('admin.peminjamans.history') }}">Lihat Laporan Denda</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Informasi Sistem Dinamis --}}
    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="card-header py-3" style="background-color: #f8f9fa; color: #6f42c1; font-weight: bold;">
            <i class="fas fa-info-circle me-1"></i>
            Informasi Sistem
        </div>
        <div class="card-body">
            <p>Halo <strong style="color: #d63384;">{{ Auth::user()->name }}</strong>, 
            kamu login sebagai <strong style="color: #6f42c1;">{{ ucfirst(auth()->user()->role) }}</strong>.</p>
            
            <hr>

            @if(auth()->user()->role == 'petugas')
                <p>Sebagai <strong>Petugas</strong>, tugas utama kamu adalah:</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item border-0 ps-0"><i class="fas fa-check-circle text-success me-2"></i> Menyetujui atau menolak permintaan peminjaman alat.</li>
                    <li class="list-group-item border-0 ps-0"><i class="fas fa-undo-alt text-primary me-2"></i> Memantau pengembalian alat dari peminjam.</li>
                    <li class="list-group-item border-0 ps-0"><i class="fas fa-file-alt text-info me-2"></i> Mencetak laporan peminjaman sebagai arsip.</li>
                </ul>
                <p class="text-muted small">Gunakan menu di samping untuk mulai bekerja.</p>
            @else
                <p>Sebagai <strong>Admin</strong>, kamu memiliki akses penuh untuk:</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item border-0 ps-0"><i class="fas fa-database text-warning me-2"></i> Mengelola data master (Alat, Kategori, dan User).</li>
                    <li class="list-group-item border-0 ps-0"><i class="fas fa-exchange-alt text-danger me-2"></i> Mengelola seluruh data transaksi peminjaman dan denda.</li>
                    <li class="list-group-item border-0 ps-0"><i class="fas fa-history text-dark me-2"></i> Memantau Log Aktivitas sistem.</li>
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection