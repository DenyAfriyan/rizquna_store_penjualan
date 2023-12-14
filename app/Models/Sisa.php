<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sisa extends Model
{
    use HasFactory;
    protected $table = 'sisa';

    protected $fillable = [
        "jenis_limbah_id",
        "sisa_akhir",
        "jenis_transaksi",
    ];
    public function jenis_limbah(): BelongsTo
    {
        return $this->belongsTo(JenisLimbah::class,'jenis_limbah_id','id');
    }
    public function limbah_masuk(): HasMany
    {
        return $this->hasMany(JenisLimbah::class);
    }
}
