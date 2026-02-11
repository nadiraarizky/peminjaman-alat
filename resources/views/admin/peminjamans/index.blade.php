@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 style="color: #6f42c1; font-weight: 800;">Persetujuan Pinjaman</h1>
            <p style="color: #d63384; font-weight: 500;">Daftar permintaan alat yang menunggu konfirmasi Anda.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded shadow-sm border">
            <span class="text-muted small text-uppercase fw-bold">Total Pending:</span>
            <span class="ms-2 h4 fw-black text-purple" style="color: #6f42c1;">{{ $peminjamans->count() }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f0fc;">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Peminjam</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Alat</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Jumlah</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $item)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" 
                                             style="width: 40px; height: 40px; background-color: #6f42c1;">
                                            {{ substr($item->user->name, 0, 1) }}
                                        </div>
                                        <span class="fw-bold text-dark">{{ $item->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle fw-semibold text-secondary">
                                    {{ $item->alat->nama_alat }}
                                </td>
                                <td class="px-4 py-3 align-middle text-center fw-bold text-purple" style="color: #6f42c1;">
                                    {{ $item->jumlah_pinjam }}
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.peminjamans.approve', $item->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm px-3 rounded-pill fw-bold shadow-sm">
                                                Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.peminjamans.reject', $item->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm px-3 rounded-pill fw-bold shadow-sm">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-5 text-center text-muted italic">
                                    Tidak ada pengajuan baru yang menunggu.
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