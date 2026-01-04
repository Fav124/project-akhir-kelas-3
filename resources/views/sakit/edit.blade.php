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
                    <a href="{{ route('sakit.index') }}" class="text-decoration-none">Santri Sakit</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Data Kesehatan
                </li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-0">Edit Data Kesehatan Santri</h4>
        <small class="text-muted">Perbarui data kesehatan santri</small>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-heart-pulse me-2 text-primary"></i> Form Edit Data Kesehatan
            </h5>

            <form method="POST" action="{{ route('sakit.update', $sakit->id) }}">
                @csrf
                @method('PUT')

                <!-- SANTRI -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Santri</label>
                    <select class="form-select @error('santri_id') is-invalid @enderror" id="santri_id" name="santri_id"
                        required>
                        <option selected disabled>-- Pilih Santri --</option>
                        @foreach ($santri as $s)
                            <option value="{{ $s->id }}"
                                {{ old('santri_id', $sakit->santri_id) == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('santri_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TINGGI BADAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tinggi Badan (cm)</label>
                    <input type="number" class="form-control @error('tinggi_badan') is-invalid @enderror" id="tinggi_badan"
                        placeholder="Contoh: 165" name="tinggi_badan" step="0.1"
                        value="{{ old('tinggi_badan', $sakit->tinggi_badan) }}" required>
                    @error('tinggi_badan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BERAT BADAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Berat Badan (kg)</label>
                    <input type="number" class="form-control @error('berat_badan') is-invalid @enderror" id="berat_badan"
                        placeholder="Contoh: 65" name="berat_badan" step="0.1"
                        value="{{ old('berat_badan', $sakit->berat_badan) }}" required>
                    @error('berat_badan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- GOLONGAN DARAH -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Golongan Darah</label>
                    <select class="form-select @error('golongan_darah') is-invalid @enderror" id="golongan_darah"
                        name="golongan_darah">
                        <option selected>-- Pilih Golongan Darah --</option>
                        <option value="A"
                            {{ old('golongan_darah', $sakit->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B"
                            {{ old('golongan_darah', $sakit->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB"
                            {{ old('golongan_darah', $sakit->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O"
                            {{ old('golongan_darah', $sakit->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                    @error('golongan_darah')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CATATAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" rows="3"
                        placeholder="Catatan kesehatan" name="catatan">{{ old('catatan', $sakit->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between gap-2">
                    <a href="{{ route('sakit.index') }}" class="btn btn-secondary flex-grow-1">
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
