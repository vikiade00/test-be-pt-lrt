<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable =[
        'nama_barang',
        'kategori_barang',
        'jumlah_barang',
        'harga_per_unit',
        'tanggal_masuk',
    ];
}
