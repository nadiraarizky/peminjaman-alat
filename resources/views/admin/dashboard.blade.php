@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Judul tetap tapi warna diubah --}}
    <h1 class="mt-4" style="color: #6f42c1;">Dashboard Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384;">Selamat Datang, {{ Auth::user()->name }}!</li>
    </ol>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            {{-- Warna diganti Ungu --}}
            <div class="card text-white mb-4" style="background-color: #6f42c1; border: none;">
                <div class="card-body">Total Alat</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('admin/alats') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            {{-- Warna diganti Pink --}}
            <div class="card text-white mb-4" style="background-color: #d63384; border: none;">
                <div class="card-body">Alat Tersedia</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu informasi tetap dengan sedikit sentuhan warna --}}
    <div class="card mb-4">
        <div class="card-header" style="background-color: #f8f9fa; color: #6f42c1;">
            <i class="fas fa-info-circle me-1"></i>
            Informasi Sistem
        </div>
        <div class="card-body">
            Halo <strong style="color: #d63384;">{{ Auth::user()->name }}</strong>, kamu login sebagai <strong style="color: #6f42c1;">{{ Auth::user()->role }}</strong>. 
            Gunakan menu di samping untuk mengelola data alat, kategori, dan peminjaman.
        </div>
    </div>
</div>
@endsection