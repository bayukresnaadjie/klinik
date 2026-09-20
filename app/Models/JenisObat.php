<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisObat extends Model
{
    protected $table      = 'jenis_obat';
    protected $primaryKey = 'id_jenis';

    protected $fillable = ['nama_jenis'];

    // Relasi: satu jenis punya banyak obat
    public function obat()
    {
        return $this->hasMany(Obat::class, 'id_jenis', 'id_jenis');
    }
}
