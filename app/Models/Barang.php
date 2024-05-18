<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';

    protected $fillable = [
        "nama_barang",
        "jenis_barang",
        "deskripsi_barang",
        "merek",
        "ukuran",
        "harga_satuan",
        "gambar_barang",
        "stok",
   ];
}
