@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1;">Katalog Alat</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384;">Pilih alat yang ingin kamu pinjam</li>
    </ol>

    <div class="card mb-4 shadow-sm" style="border-radius: 15px; border: none;">
        <div class="card-header" style="background-color: #6f42c1; color: white; border-radius: 15px 15px 0 0;">
            <i class="fas fa-boxes me-1"></i>
            Daftar Alat Tersedia
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Alat</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alats as $alat)
                    <tr>
                        <td><strong>{{ $alat->nama_alat }}</strong></td>
                        <td><span class="badge bg-success">{{ $alat->jumlah }} Tersedia</span></td>
                        <td>
                            {{-- Link href di bawah ini sudah diperbaiki --}}
                            <a href="{{ route('user.pinjam.create', ['alat_id' => $alat->id]) }}" 
                               class="btn btn-sm text-white" 
                               style="background-color: #d63384; border-radius: 8px;">
                                <i class="fas fa-plus me-1"></i> Pinjam
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection