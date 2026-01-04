@extends('layouts.master')
@section('content')
    <!-- PAGE HEADER -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Laporan Pemeriksaan
                </li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0">Laporan Pemeriksaan Santri</h4>
                <small class="text-muted">Kelola laporan pemeriksaan kesehatan santri</small>
            </div>
            <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Laporan
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Berhasil!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- DATA TABLE -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($laporan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Santri</th>
                                <th>Keluhan</th>
                                <th>Suhu Tubuh</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                    <td>{{ $item->santri->nama_lengkap ?? 'N/A' }}</td>
                                    <td>{{ substr($item->keluhan, 0, 30) }}{{ strlen($item->keluhan) > 30 ? '...' : '' }}
                                    </td>
                                    <td>{{ $item->suhu_tubuh }}°C</td>
                                    <td>
                                        @if ($item->status_kondisi == 'sehat')
                                            <span class="badge bg-success">Sehat</span>
                                        @elseif ($item->status_kondisi == 'sakit-ringan')
                                            <span class="badge bg-warning">Sakit Ringan</span>
                                        @else
                                            <span class="badge bg-danger">Sakit Berat</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('laporan.edit', $item->id) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('laporan.destroy', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                    <p class="text-muted">Belum ada laporan pemeriksaan</p>
                    <a href="{{ route('laporan.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Laporan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
