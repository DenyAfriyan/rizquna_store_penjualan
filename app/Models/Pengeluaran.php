<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';

        
    protected $fillable = [
        "jenis_limbah_id",
        "vendor_id",
        "sisa_id",
        "jumlah_limbah_keluar",
        "bukti_nomor_dokumen",
        "tanggal_keluar",
   ];

   public function jenis_limbah(): BelongsTo
    {
        return $this->belongsTo(JenisLimbah::class,'jenis_limbah_id','id');
    }
   public function vendor(): BelongsTo
    {
        return $this->belongsTo(vendor::class,'vendor_id','id');
    }
}
