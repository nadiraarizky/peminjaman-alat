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
            <button type="button" class="btn-close" data-bs-alert="alert" aria-label="Close"></button>
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
                                    {{-- Tombol Edit Baru --}}
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
@endsection