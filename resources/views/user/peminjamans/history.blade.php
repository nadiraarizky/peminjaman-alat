@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1;">Riwayat Peminjaman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384;">Daftar alat yang sudah dikembalikan atau ditolak</li>
    </ol>

    <div class="card mb-4 shadow-sm" style="border-radius: 15px; border: none;">
        <div class="card-header" style="background-color: #6f42c1; color: white; border-radius: 15px 15px 0 0;">
            <i class="fas fa-history me-1"></i>
            Catatan Riwayat
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Status Akhir</th>
                        <th>Tgl Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $history)
                    <tr>
                        <td><strong>{{ $history->alat->nama_alat }}</strong></td>
                        {{-- Bagian yang diubah ada di bawah ini: jumlah -> jumlah_pinjam --}}
                        <td>{{ $history->jumlah_pinjam }}</td>
                        <td>
                            @if($history->status == 'kembali')
                                <span class="badge bg-info text-dark">Selesai/Kembali</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $history->updated_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada riwayat peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection