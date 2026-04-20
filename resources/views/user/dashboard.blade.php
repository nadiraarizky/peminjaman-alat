@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Judul Dashboard User --}}
    <h1 class="mt-4" style="color: #6f42c1;">Dashboard User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384;">Selamat Datang, {{ Auth::user()->name }}!</li>
    </ol>

    <div class="row">
        {{-- Kotak Ungu: Pinjaman Saya --}}
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background-color: #6f42c1; border: none;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Pinjaman Saya</div>
                        <h3 class="mb-0">{{ $jumlahPinjaman }}</h3>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('user.pinjam.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        {{-- Kotak Pink: Total Denda --}}
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background-color: #d63384; border: none;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Total Denda</div>
                        <h4 class="mb-0">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('user.pinjam.history') }}">Lihat Riwayat</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Informasi --}}
    <div class="card mb-4">
        <div class="card-header" style="background-color: #f8f9fa; color: #6f42c1;">
            <i class="fas fa-info-circle me-1"></i>
            Informasi Peminjaman
        </div>
        <div class="card-body">
            Halo <strong style="color: #d63384;">{{ Auth::user()->name }}</strong>, kamu login sebagai <strong style="color: #6f42c1;">{{ Auth::user()->role }}</strong>. 
            Gunakan menu di samping untuk melihat katalog alat dan mengelola pinjaman kamu.
        </div>
    </div>
</div>
@endsection