<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';

    protected $fillable = [
        "barang_id",
        "qty",
        "nama_karyawan",
   ];

   public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class,'barang_id','id');
    }
}
