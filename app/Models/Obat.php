<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obats';

    protected $fillable = [
        'nama_obat',
        'foto',
        'deskripsi',
        'stok',
        'satuan',
        'stok_minimum', // Tambahan untuk alert stok menipis
        'harga_satuan'  // Tambahan untuk tracking harga
    ];

    protected $casts = [
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'harga_satuan' => 'decimal:2'
    ];

    // Relasi many-to-many dengan sakit_santri
    public function sakitSantris()
    {
        return $this->belongsToMany(SakitSantri::class, 'sakit_santri_obat')
            ->withPivot('jumlah', 'dosis', 'keterangan')
            ->withTimestamps();
    }

    // Check if stock is low
    public function isStockLow()
    {
        return $this->stok <= $this->stok_minimum;
    }

    // Reduce stock
    public function reduceStock($amount)
    {
        if ($this->stok >= $amount) {
            $this->decrement('stok', $amount);
            return true;
        }
        return false;
    }
}
