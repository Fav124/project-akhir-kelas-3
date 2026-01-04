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
                    <a href="{{ route('santri.index') }}" class="text-decoration-none">Data Santri</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Santri
                </li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-0">Edit Data Santri</h4>
        <small class="text-muted">
            Perbarui data identitas santri dengan benar
        </small>
    </div>

    <!-- TWO COLUMN LAYOUT -->
    <div class="row g-4">

        <!-- LEFT SECTION - FORM INPUT -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-pencil-square me-2 text-primary"></i> Form Edit Data
                    </h5>

                    <form method="PUT" action="{{ route('santri.update', $santri->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- SANTRI SECTION -->
                        <h6 class="fw-bold text-primary mb-3">Data Santri</h6>

                        <!-- NIS -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">NIS</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-badge"></i>
                                </span>
                                <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis"
                                    placeholder="Masukkan NIS" name="nis" value="{{ old('nis', $santri->nis) }}"
                                    required>
                            </div>
                            @error('nis')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NAMA -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" placeholder="Nama lengkap santri" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required>
                            </div>
                            @error('nama_lengkap')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- JENIS KELAMIN -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin" required>
                                <option selected disabled>-- Pilih --</option>
                                <option value="laki-laki"
                                    {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="perempuan"
                                    {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- KELAS -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas</label>
                            <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id"
                                name="kelas_id" required>
                                <option selected disabled>-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('kelas_id', $santri->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TEMPAT LAHIR -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                id="tempat_lahir" placeholder="Kota lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TANGGAL LAHIR -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $santri->tanggal_lahir) }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- WALI SECTION -->
                        <h6 class="fw-bold text-primary mb-3">Data Wali Santri</h6>

                        <!-- NAMA WALI -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap Wali</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" class="form-control @error('nama_wali') is-invalid @enderror"
                                    id="nama_wali" placeholder="Nama lengkap wali" name="nama_wali"
                                    value="{{ old('nama_wali', $wali->nama_wali ?? '') }}" required>
                            </div>
                            @error('nama_wali')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- HUBUNGAN -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hubungan dengan Santri</label>
                            <select class="form-select @error('hubungan') is-invalid @enderror" id="hubungan"
                                name="hubungan" required>
                                <option selected disabled>-- Pilih Hubungan --</option>
                                <option value="Ayah"
                                    {{ old('hubungan', $wali->hubungan ?? '') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                <option value="Ibu"
                                    {{ old('hubungan', $wali->hubungan ?? '') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="Wali"
                                    {{ old('hubungan', $wali->hubungan ?? '') == 'Wali' ? 'selected' : '' }}>Wali</option>
                            </select>
                            @error('hubungan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NOMOR HP -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor HP Wali</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="tel" class="form-control @error('no_hp') is-invalid @enderror"
                                    id="no_hp" placeholder="08xx xxxx xxxx" name="no_hp"
                                    value="{{ old('no_hp', $wali->no_hp ?? '') }}" required>
                            </div>
                            @error('no_hp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TEMPAT LAHIR WALI -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tempat Lahir Wali</label>
                            <input type="text" class="form-control @error('wali_tempat_lahir') is-invalid @enderror"
                                id="wali_tempat_lahir" placeholder="Kota lahir" name="wali_tempat_lahir"
                                value="{{ old('wali_tempat_lahir', $wali->tempat_lahir ?? '') }}" required>
                            @error('wali_tempat_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TANGGAL LAHIR WALI -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Lahir Wali</label>
                            <input type="date" class="form-control @error('wali_tanggal_lahir') is-invalid @enderror"
                                id="wali_tanggal_lahir" name="wali_tanggal_lahir"
                                value="{{ old('wali_tanggal_lahir', $wali->tanggal_lahir ?? '') }}" required>
                            @error('wali_tanggal_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ALAMAT -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" rows="3"
                                placeholder="Alamat rumah wali" name="alamat" required>{{ old('alamat', $wali->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('santri.index') }}" class="btn btn-secondary flex-grow-1">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-save me-1"></i> Perbarui
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- RIGHT SECTION - DATA PREVIEW -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-list-check me-2 text-primary"></i> Data Santri
                    </h5>
                </div>

                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">Informasi Santri</h6>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">NIS</div>
                        <div class="col-sm-8">: {{ $santri->nis }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Nama</div>
                        <div class="col-sm-8">: {{ $santri->nama_lengkap }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Jenis Kelamin</div>
                        <div class="col-sm-8">: {{ ucfirst($santri->jenis_kelamin) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Kelas</div>
                        <div class="col-sm-8">: {{ $santri->kelas->nama_kelas ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Tempat Lahir</div>
                        <div class="col-sm-8">: {{ $santri->tempat_lahir }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Tanggal Lahir</div>
                        <div class="col-sm-8">: {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->format('d-m-Y') }}</div>
                    </div>

                    <hr>

                    <h6 class="fw-bold text-primary mb-3">Informasi Wali</h6>
                    @if ($wali)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Nama Wali</div>
                            <div class="col-sm-8">: {{ $wali->nama_wali }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Hubungan</div>
                            <div class="col-sm-8">: {{ $wali->hubungan }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">No HP</div>
                            <div class="col-sm-8">: {{ $wali->no_hp }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Alamat</div>
                            <div class="col-sm-8">: {{ $wali->alamat }}</div>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada data wali</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
