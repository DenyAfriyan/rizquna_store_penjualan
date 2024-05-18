<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar';

    protected $fillable = [
        "barang_id",
        "qty",
        "margin",
        "nama_karyawan",
   ];

   public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class,'barang_id','id');
    }
}
