@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 style="color: #6f42c1; font-weight: bold;">Log Aktivitas Sistem</h1>
            <p style="color: #d63384; margin-bottom: 0;">Memantau setiap aksi penambahan, perubahan, dan penghapusan data.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.logs.exportPDF') }}" class="btn btn-danger shadow-sm px-3">
                <i class="fas fa-file-pdf me-2"></i>Cetak PDF
            </a>

            @if($logs->count() > 0)
            <form action="{{ route('admin.logs.destroyAll') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA riwayat aktivitas?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-secondary shadow-sm px-3">
                    <i class="fas fa-trash-alt me-2"></i>Bersihkan Log
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <i class="fas fa-history me-1" style="color: #6f42c1;"></i>
            <span style="font-weight: bold; color: #6f42c1;">Riwayat Aktivitas</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f0fc; color: #6f42c1;">
                        <tr>
                            <th class="px-4 py-3">Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Detail Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr style="vertical-align: middle;">
                            <td class="px-4 text-muted" style="font-size: 0.85rem;">
                                {{ $log->created_at->format('d M Y') }} <br>
                                <span class="badge bg-light text-dark">{{ $log->created_at->format('H:i:s') }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: #e9ecef;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="color: #6f42c1;">{{ $log->user->name }}</div>
                                        <small class="text-muted">{{ ucfirst($log->user->role) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(str_contains($log->activity, 'Tambah'))
                                    <span class="badge rounded-pill bg-success px-3">Tambah</span>
                                @elseif(str_contains($log->activity, 'Update'))
                                    <span class="badge rounded-pill bg-warning text-dark px-3">Update</span>
                                @else
                                    <span class="badge rounded-pill bg-danger px-3">Hapus</span>
                                @endif
                            </td>
                            <td class="text-secondary">{{ $log->description }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="fas fa-info-circle mb-3 fa-3x" style="color: #e9ecef;"></i><br>
                                    <h5 class="text-secondary">Belum ada riwayat tercatat</h5>
                                    <p class="small">Semua aktivitas admin akan otomatis muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        border-bottom: none;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .table tbody td {
        border-color: #f1f1f1;
        padding: 1rem 0.75rem;
    }
    .btn-danger {
        background-color: #d63384;
        border-color: #d63384;
    }
    .btn-danger:hover {
        background-color: #b92a6e;
        border-color: #b92a6e;
    }
    .gap-2 { gap: 0.5rem; }
</style>
@endsection