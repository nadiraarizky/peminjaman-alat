@extends('layouts.admin')

@section('title', 'Tambah Alat')

@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4">Tambah Alat</h1>

    <div class="card mb-4">
        <div class="card-header">
            Form Tambah Alat
        </div>

        <div class="card-body">

            <form action="{{ route('admin.alats.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Alat</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number"
                           name="stok"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    Simpan
                </button>

                <a href="{{ route('admin.alats.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

@endsection
