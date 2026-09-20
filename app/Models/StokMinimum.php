<?php

// app/Models/StokMinimum.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMinimum extends Model
{
    protected $table      = 'stok_minimum';
    protected $primaryKey = 'id_stok_min';

    protected $fillable = [
        'id_varian',
        'batas_minimum',
    ];

    // Relasi ke varian obat
    public function varianObat()
    {
        return $this->belongsTo(VarianObat::class, 'id_varian', 'id_varian');
    }
}
