<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penerimaan extends Model
{
    use HasFactory;
    protected $table = 'penerimaan';
        
    protected $fillable = [
        "jenis_limbah_id",
        "sumber_limbah_id",
        "sisa_id",
        "jumlah_limbah_masuk",
        "tanggal_masuk",
        "maksimal_penyimpanan",
   ];

   public function jenis_limbah(): BelongsTo
    {
        return $this->belongsTo(JenisLimbah::class,'jenis_limbah_id','id');
    }
   public function sisa_limbah() : BelongsTo
   {
        return $this->belongsTo(Sisa::class,'sisa_id','id');
   }
   public function sumber_limbah(): BelongsTo
    {
        return $this->belongsTo(SumberLimbah::class,'sumber_limbah_id','id');
    }
}
