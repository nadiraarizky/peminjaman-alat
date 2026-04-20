@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #6f42c1; font-weight: 800;">Riwayat Peminjaman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" style="color: #d63384; font-weight: 500;">Daftar alat yang sudah dikembalikan atau ditolak</li>
    </ol>

    <div class="card mb-4 shadow-sm" style="border-radius: 20px; border: none; overflow: hidden;">
        <div class="card-header py-3" style="background-color: #6f42c1; color: white;">
            <i class="fas fa-history me-1"></i>
            Catatan Riwayat
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Alat</th>
                            <th class="px-4 py-3 text-center">Jumlah</th>
                            <th class="px-4 py-3 text-center">Status Akhir</th>
                            <th class="px-4 py-3 text-center">Tgl Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $history)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark">{{ $history->alat->nama_alat }}</div>
                            </td>
                            <td class="px-4 py-3 text-center fw-bold">{{ $history->jumlah_pinjam }}</td>
                            <td class="px-4 py-3 text-center">
                                {{-- PERBAIKAN DI SINI: Sesuaikan dengan status 'dikembalikan' --}}
                                @if($history->status == 'dikembalikan')
                                    <span class="badge bg-success rounded-pill px-3 shadow-sm">
                                        <i class="fas fa-check-circle me-1"></i> DIKEMBALIKAN
                                    </span>
                                @elseif($history->status == 'ditolak')
                                    <span class="badge bg-danger rounded-pill px-3 shadow-sm">
                                        <i class="fas fa-times-circle me-1"></i> DITOLAK
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 shadow-sm">
                                        {{ strtoupper($history->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-muted">
                                {{ $history->updated_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-5 text-center text-muted">
                                <i class="fas fa-info-circle me-1"></i> Belum ada riwayat peminjaman.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection