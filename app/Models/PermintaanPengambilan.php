<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PermintaanPengambilan extends Model
{
    use HasFactory;
    protected $table = 'permintaan_pengambilan';
    protected $fillable = [
        'jenis_limbah_id',
        'sumber_limbah_id',
        'notes',
    ];

    public function jenis_limbah(): BelongsTo
    {
        return $this->belongsTo(JenisLimbah::class,'jenis_limbah_id','id');
    }

    public function sumber_limbah(): BelongsTo
    {
        return $this->belongsTo(SumberLimbah::class,'sumber_limbah_id','id');
    }
}
