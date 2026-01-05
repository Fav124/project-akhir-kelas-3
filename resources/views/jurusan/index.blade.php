@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-diagram-3 me-2"></i>Manajemen Jurusan
        </h4>
        <a href="{{ route('jurusan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Jurusan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jurusan</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Kelas</th>
                            <th>Jumlah Santri</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurusans as $index => $jurusan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-semibold">{{ $jurusan->nama }}</span>
                            </td>
                            <td>{{ $jurusan->deskripsi ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $jurusan->kelas_count }} Kelas</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $jurusan->santris_count }} Santri</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('jurusan.edit', $jurusan) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('jurusan.destroy', $jurusan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus jurusan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data jurusan
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
