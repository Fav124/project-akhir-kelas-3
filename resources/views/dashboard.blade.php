@extends('layouts.master')
@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron-hero mb-4 shadow-sm rounded-3">
        <div class="hero-overlay"></div>

        <div class="container-fluid p-4 hero-content">
            <h1 class="display-5 fw-bold text-white">Selamat Datang, Admin!</h1>
            <p class="col-md-8 fs-5 text-white">
                Kelola data santri, kelas, obat, dan laporan dengan mudah.
            </p>
            <a href="{{ route('santri.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-right me-2"></i> Mulai Kelola Data
            </a>
        </div>
    </div>


    <!-- STAT CARDS -->
    <div class="row g-4 mt-2">

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-people me-2"></i> Total Santri
                </h5>
                <h2 class="fw-bold text-primary">{{ $totalSantri }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-building me-2"></i> Total Kelas
                </h5>
                <h2 class="fw-bold text-primary">{{ $totalKelas }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-capsule-pill me-2"></i> Total Obat
                </h5>
                <h2 class="fw-bold text-primary">{{ $totalObat }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-file-earmark-text me-2"></i> Total Laporan
                </h5>
                <h2 class="fw-bold text-primary">{{ $totalLaporan }}</h2>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <h5 class="fw-bold mb-3">Akses Cepat</h5>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-people text-primary me-2"></i> Data Santri
                    </h6>
                    <p class="text-muted small mb-3">Kelola data santri dan informasi pribadi mereka</p>
                    <a href="{{ route('santri.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-building text-primary me-2"></i> Kelola Kelas
                    </h6>
                    <p class="text-muted small mb-3">Tambah atau kelola data kelas santri</p>
                    <a href="{{ route('kelas.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-heart-pulse text-primary me-2"></i> Santri Sakit
                    </h6>
                    <p class="text-muted small mb-3">Lihat dan kelola data kesehatan santri</p>
                    <a href="{{ route('sakit.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-capsule-pill text-primary me-2"></i> Kelola Obat
                    </h6>
                    <p class="text-muted small mb-3">Kelola stok dan data obat</p>
                    <a href="{{ route('obat.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-file-earmark-text text-primary me-2"></i> Laporan Pemeriksaan
                    </h6>
                    <p class="text-muted small mb-3">Lihat laporan pemeriksaan kesehatan santri</p>
                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
