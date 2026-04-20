@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1; font-weight: bold;">Data Inventaris Alat</h1>
    
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('admin.alats.create') }}" class="btn" style="background-color: #d63384; color: white; border-radius: 5px;">
            <i class="fas fa-plus-circle me-1"></i> Tambah Alat Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background-color: #f8f0fc; color: #6f42c1;">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Alat</th>
                            <th>Kategori</th>
                            <th>Kondisi</th>
                            <th>Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alats as $alat)
                        <tr>
                            <td class="fw-bold text-muted">{{ $alat->kode_alat }}</td>
                            <td>{{ $alat->nama_alat }}</td>
                            <td>
                                <span class="badge" style="background-color: #6f42c1;">
                                    {{ $alat->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td>
                                @if($alat->kondisi == 'baru')
                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i> Baru</span>
                                @elseif($alat->kondisi == 'bekas')
                                    <span class="text-warning"><i class="fas fa-history me-1"></i> Bekas</span>
                                @else
                                    <span class="text-danger"><i class="fas fa-times-circle me-1"></i> Rusak</span>
                                @endif
                            </td>
                            <td>{{ $alat->jumlah }} Unit</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Detail --}}
                                    <button type="button" class="btn btn-sm btn-outline-info" style="border-radius: 5px;" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $alat->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.alats.edit', $alat->id) }}" class="btn btn-sm btn-outline-warning" style="border-radius: 5px;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.alats.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 5px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DILETAKKAN DI LUAR CARD & TABEL AGAR TIDAK BERANTAKAN --}}
@foreach($alats as $alat)
<div class="modal fade" id="modalDetail{{ $alat->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background-color: #f8f0fc; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" style="color: #6f42c1;">Detail Alat: {{ $alat->nama_alat }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-start"> {{-- Tambahkan text-start agar teks rata kiri --}}
                <div class="text-center mb-4">
                    @if($alat->gambar)
                        <img src="{{ asset('storage/' . $alat->gambar) }}" class="img-fluid rounded shadow-sm" style="max-height: 200px;" alt="Gambar Alat">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center mx-auto rounded" style="width: 150px; height: 150px;">
                            <i class="fas fa-tools fa-3x text-muted"></i>
                        </div>
                        <p class="text-muted small mt-2">Tidak ada gambar tersedia</p>
                    @endif
                </div>
                <table class="table table-sm table-borderless"> {{-- Gunakan table-borderless agar lebih rapi --}}
                    <tr>
                        <td class="fw-bold text-muted w-25">Kode</td>
                        <td>: {{ $alat->kode_alat }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Kategori</td>
                        <td>: {{ $alat->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Stok</td>
                        <td>: {{ $alat->jumlah }} Unit</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Kondisi</td>
                        <td>: {{ ucfirst($alat->kondisi) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Deskripsi</td>
                        <td style="white-space: pre-line;">: {{ $alat->deskripsi ?? 'Tidak ada deskripsi.' }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection