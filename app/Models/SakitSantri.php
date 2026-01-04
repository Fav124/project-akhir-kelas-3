<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SakitSantri extends Model
{
    use HasFactory;

    protected $table = 'sakit_santris';

    protected $fillable = [
        'santri_id',
        'foto',
        'tanggal_mulai_sakit',
        'tanggal_selesai_sakit',
        'diagnosis',
        'gejala',
        'tindakan',
        'resep_obat',
        'suhu_tubuh',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_mulai_sakit' => 'date',
        'tanggal_selesai_sakit' => 'date',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    // Relasi many-to-many dengan obat
    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'sakit_santri_obat')
            ->withPivot('jumlah', 'dosis', 'keterangan')
            ->withTimestamps();
    }
}
