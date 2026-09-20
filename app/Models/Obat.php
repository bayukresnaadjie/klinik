<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table      = 'obat';
    protected $primaryKey = 'id_obat';

    protected $fillable = ['id_jenis', 'nama_obat', 'stok'];

    // Relasi ke jenis obat
    public function jenisObat()
    {
        return $this->belongsTo(JenisObat::class, 'id_jenis', 'id_jenis');
    }

    // Relasi: satu obat punya banyak varian
    public function varianObat()
    {
        return $this->hasMany(VarianObat::class, 'id_obat', 'id_obat');
    }
}
