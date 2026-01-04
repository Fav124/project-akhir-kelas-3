@extends('layouts.master')
@section('content')
    <!-- PAGE HEADER -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('kelas.index') }}" class="text-decoration-none">Data Kelas</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Kelas
                </li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-0">Edit Data Kelas</h4>
        <small class="text-muted">Perbarui data kelas</small>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-pencil-square me-2 text-primary"></i> Form Edit Kelas
            </h5>

            <form method="POST" action="{{ route('kelas.update', $kela->id) }}">
                @csrf
                @method('PUT')

                <!-- NAMA KELAS -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Kelas</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-building"></i>
                        </span>
                        <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas"
                            placeholder="Contoh: Kelas 1 A" name="nama_kelas"
                            value="{{ old('nama_kelas', $kela->nama_kelas) }}" required>
                    </div>
                    @error('nama_kelas')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between gap-2">
                    <a href="{{ route('kelas.index') }}" class="btn btn-secondary flex-grow-1">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-save me-1"></i> Perbarui
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
