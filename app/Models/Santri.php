<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    
    protected $table = 'santris';
    protected $fillable = [
        'foto',
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'kelas_id',
        'tempat_lahir',
        'tanggal_lahir',
        'status'
    ];

    public function kelas ()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function info()
    {
        return $this->belongsTo(InfoKesehatanSantri::class);
    }

    public function riwayat()
    {
        return $this->belongsTo(RiwayatPemeriksaan::class);
    }
}
