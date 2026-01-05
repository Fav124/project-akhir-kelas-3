@extends('layouts.master')
@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron-hero mb-4 shadow-sm rounded-3">
        <div class="hero-overlay"></div>

        <div class="container-fluid p-4 hero-content">
            <h1 class="display-5 fw-bold text-white">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="col-md-8 fs-5 text-white">
                Kelola data santri, kelas, obat, dan laporan dengan mudah.
            </p>
            <a href="{{ route('santri.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-right me-2"></i> Mulai Kelola Data
            </a>
        </div>
    </div>

    <!-- ALERT CARDS -->
    @if($obatKadaluarsa > 0 || $obatStokRendah > 0 || $obatExpired > 0)
    <div class="row g-3 mb-4">
        @if($obatExpired > 0)
        <div class="col-md-4">
            <div class="alert alert-danger mb-0 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>{{ $obatExpired }} obat sudah kadaluarsa!</strong>
                    <br><small>Segera tarik dari peredaran</small>
                </div>
            </div>
        </div>
        @endif
        
        @if($obatKadaluarsa > 0)
        <div class="col-md-4">
            <div class="alert alert-warning mb-0 d-flex align-items-center">
                <i class="bi bi-clock-history fs-4 me-3"></i>
                <div>
                    <strong>{{ $obatKadaluarsa }} obat mendekati kadaluarsa</strong>
                    <br><small>Akan expired dalam 30 hari</small>
                </div>
            </div>
        </div>
        @endif
        
        @if($obatStokRendah > 0)
        <div class="col-md-4">
            <div class="alert alert-info mb-0 d-flex align-items-center">
                <i class="bi bi-box-seam fs-4 me-3"></i>
                <div>
                    <strong>{{ $obatStokRendah }} obat stok rendah</strong>
                    <br><small>Segera lakukan restok</small>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

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
            <div class="card stat-card shadow-sm p-3 border-danger">
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-heart-pulse me-2 text-danger"></i> Santri Sakit
                </h5>
                <h2 class="fw-bold text-danger">{{ $santriSedangSakit }}</h2>
                <small class="text-muted">{{ $sakitHariIni }} hari ini</small>
            </div>
        </div>

    </div>

    <div class="row g-4 mt-2">
        <!-- Top 5 Santri Sering Sakit -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-graph-up-arrow text-danger me-2"></i>
                        Top 5 Santri Sering Sakit (Bulan Ini)
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($topSantriSakit->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Santri</th>
                                    <th>Kelas</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topSantriSakit as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                            @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person text-white small"></i>
                                            </div>
                                            @endif
                                            {{ $item->nama_lengkap }}
                                        </div>
                                    </td>
                                    <td>{{ $item->nama_kelas ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $item->sakit_count }}x</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-emoji-smile fs-1 d-block mb-2"></i>
                        Tidak ada data sakit bulan ini
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Obat Mendekati Kadaluarsa -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                        Obat Mendekati Kadaluarsa
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($obatMendekatiKadaluarsa->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Stok</th>
                                    <th>Kadaluarsa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obatMendekatiKadaluarsa as $obat)
                                <tr>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td>{{ $obat->stok }} {{ $obat->satuan }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ $obat->tanggal_kadaluarsa->format('d M Y') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                        Semua obat masih aman
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <!-- Obat Stok Rendah -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-box-seam text-info me-2"></i>
                        Obat Stok Rendah
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($obatStokRendahList->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Stok</th>
                                    <th>Minimum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obatStokRendahList as $obat)
                                <tr>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ $obat->stok }} {{ $obat->satuan }}</span>
                                    </td>
                                    <td>{{ $obat->stok_minimum }} {{ $obat->satuan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                        Semua stok aman
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Record Sakit Terbaru -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        Record Sakit Terbaru
                    </h6>
                    <a href="{{ route('sakit.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if($recentSakit->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Santri</th>
                                    <th>Diagnosis</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSakit as $sakit)
                                <tr>
                                    <td>{{ $sakit->santri->nama_lengkap ?? '-' }}</td>
                                    <td>{{ Str::limit($sakit->diagnosis, 20) }}</td>
                                    <td>{{ $sakit->tanggal_mulai_sakit?->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $sakit->status_badge }}">
                                            {{ ucfirst($sakit->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada data
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <h5 class="fw-bold mb-3">Akses Cepat</h5>
        </div>

        <div class="col-md-4">
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

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-heart-pulse text-danger me-2"></i> Santri Sakit
                    </h6>
                    <p class="text-muted small mb-3">Lihat dan kelola data kesehatan santri</p>
                    <a href="{{ route('sakit.index') }}" class="btn btn-sm btn-danger">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-capsule-pill text-success me-2"></i> Kelola Obat
                    </h6>
                    <p class="text-muted small mb-3">Kelola stok dan data obat</p>
                    <a href="{{ route('obat.index') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-file-earmark-bar-graph text-info me-2"></i> Laporan
                    </h6>
                    <p class="text-muted small mb-3">Lihat laporan dan export PDF</p>
                    <a href="{{ route('laporan.report') }}" class="btn btn-sm btn-info">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-person-gear text-warning me-2"></i> Manajemen User
                    </h6>
                    <p class="text-muted small mb-3">Kelola user dan hak akses</p>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-diagram-3 text-secondary me-2"></i> Manajemen Jurusan
                    </h6>
                    <p class="text-muted small mb-3">Kelola data jurusan</p>
                    <a href="{{ route('jurusan.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-right me-1"></i> Buka
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
