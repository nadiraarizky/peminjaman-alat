@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1;">Manajemen Pengembalian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384;">Data alat yang sudah dikembalikan ke sarpras.</li>
    </ol>

    <div class="card mb-4" style="border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div class="card-header" style="background-color: #6f42c1; color: white;">
            <i class="fas fa-table me-1"></i>
            Daftar Pengembalian Selesai
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Alat</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->alat->nama_alat }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-success">Dikembalikan</span></td>
                        <td>
                            {{-- Tombol Hapus (Bagian dari CRUD Admin) --}}
                            <form action="{{ route('admin.pengembalians.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengembalian ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection