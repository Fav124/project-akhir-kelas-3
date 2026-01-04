<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Obat;
use App\Models\RiwayatPemeriksaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalSantri = Santri::count();
        $totalKelas = Kelas::count();
        $totalObat = Obat::count();
        $totalLaporan = RiwayatPemeriksaan::count();

        return view('dashboard', compact('totalSantri', 'totalKelas', 'totalObat', 'totalLaporan'));
    }

    public function coba()
    {
        return view('style.santri.create');
    }
}
