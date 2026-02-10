@extends('layouts.admin')

@section('title', 'Data Alat')

@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4">Data Alat</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-toolbox me-1"></i>
            Daftar Alat
        </div>

        <div class="card-body">

            <a href="{{ route('admin.alats.create') }}" class="btn btn-primary mb-3">
                Tambah Alat
            </a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($alats as $alat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alat->nama }}</td>
                        <td>{{ $alat->stok }}</td>
                        <td>
                            <a href="{{ route('admin.alats.edit', $alat->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('admin.alats.destroy', $alat->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin hapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Data alat belum ada.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection
