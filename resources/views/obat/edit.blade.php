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
                    <a href="{{ route('obat.index') }}" class="text-decoration-none">Data Obat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Obat
                </li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-0">Edit Data Obat</h4>
        <small class="text-muted">Perbarui data obat</small>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-capsule-pill me-2 text-primary"></i> Form Edit Obat
            </h5>

            <form method="POST" action="{{ route('obat.update', $obat->id) }}">
                @csrf
                @method('PUT')

                <!-- NAMA OBAT -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Obat</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-capsule-pill"></i>
                        </span>
                        <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat"
                            placeholder="Contoh: Paracetamol" name="nama_obat"
                            value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                    </div>
                    @error('nama_obat')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- DESKRIPSI -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" rows="3"
                        placeholder="Deskripsi obat" name="deskripsi">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- STOK -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Stok</label>
                    <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok"
                        placeholder="Contoh: 50" name="stok" min="0" value="{{ old('stok', $obat->stok) }}"
                        required>
                    @error('stok')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- SATUAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Satuan</label>
                    <select class="form-select @error('satuan') is-invalid @enderror" id="satuan" name="satuan"
                        required>
                        <option selected disabled>-- Pilih Satuan --</option>
                        <option value="Tablet" {{ old('satuan', $obat->satuan) == 'Tablet' ? 'selected' : '' }}>Tablet
                        </option>
                        <option value="Kapsul" {{ old('satuan', $obat->satuan) == 'Kapsul' ? 'selected' : '' }}>Kapsul
                        </option>
                        <option value="Botol" {{ old('satuan', $obat->satuan) == 'Botol' ? 'selected' : '' }}>Botol
                        </option>
                        <option value="Pcs" {{ old('satuan', $obat->satuan) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="Box" {{ old('satuan', $obat->satuan) == 'Box' ? 'selected' : '' }}>Box</option>
                    </select>
                    @error('satuan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between gap-2">
                    <a href="{{ route('obat.index') }}" class="btn btn-secondary flex-grow-1">
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
