<?php
// app/Models/HargaVarian.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaVarian extends Model
{
    protected $table      = 'harga_varian';
    protected $primaryKey = 'id_harga';

    protected $fillable = [
        'id_varian',
        'harga',
        'berlaku_mulai',
        'berlaku_sampai',
    ];

    protected $casts = [
        'berlaku_mulai'  => 'date',
        'berlaku_sampai' => 'date',
        'harga'          => 'decimal:2',
    ];

    public function varianObat()
    {
        return $this->belongsTo(VarianObat::class, 'id_varian', 'id_varian');
    }
}
