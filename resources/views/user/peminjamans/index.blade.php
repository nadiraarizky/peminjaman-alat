@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4">
        <h1 style="color: #6f42c1; font-weight: 800;">Pinjaman Saya</h1>
        <p style="color: #d63384; font-weight: 500;">Daftar alat yang sedang kamu pinjam atau menunggu persetujuan.</p>
    </div>

    {{-- Alert sukses bawaan Laravel (Akan otomatis dipicu juga oleh SweetAlert di layout) --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 15px;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f0fc;">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold" style="color: #6f42c1;">Nama Alat</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Jumlah</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Status</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-center" style="color: #6f42c1;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $item)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <div class="fw-bold text-dark">{{ $item->alat->nama_alat }}</div>
                                    <div class="small text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> 
                                        Dipinjam pada: {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle text-center fw-bold" style="color: #6f42c1;">
                                    {{ $item->jumlah_pinjam }}
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->status == 'pending')
                                        <span class="badge bg-warning text-dark rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-clock me-1"></i> MENUNGGU
                                        </span>
                                    @elseif($item->status == 'dipinjam')
                                        <span class="badge bg-primary rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-hand-holding me-1"></i> SEDANG DIPINJAM
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    @if($item->status == 'dipinjam')
                                        {{-- Form disembunyikan agar bisa dipicu JavaScript --}}
                                        <form id="return-form-{{ $item->id }}" action="{{ route('user.pinjam.return', $item->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>

                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold shadow-sm" 
                                            onclick="confirmReturn({{ $item->id }}, '{{ $item->alat->nama_alat }}')">
                                            <i class="fas fa-undo me-1"></i> Kembalikan
                                        </button>
                                    @else
                                        <span class="text-muted small italic">Menunggu persetujuan admin...</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-5 text-center text-muted">
                                    <i class="fas fa-info-circle mb-2 d-block fa-2x opacity-25"></i>
                                    Kamu tidak memiliki pinjaman aktif saat ini.
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

@push('scripts')
<script>
    function confirmReturn(id, namaAlat) {
        Swal.fire({
            title: 'Kembalikan Alat?',
            text: "Apakah yakin ingin mengembalikan " + namaAlat + " sekarang?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6f42c1', {{-- Warna Ungu Serasi --}}
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('return-form-' + id).submit();
            }
        })
    }
</script>
@endpush