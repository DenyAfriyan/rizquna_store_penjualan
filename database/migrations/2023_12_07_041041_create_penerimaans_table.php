<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penerimaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_limbah_id')->constrained(table:'jenis_limbah');
            $table->foreignId('sumber_limbah_id')->constrained(table:'sumber_limbah');
            $table->foreignId('sisa_id')->constrained(table:'sisa');
            $table->integer('jumlah_limbah_masuk');
            $table->dateTime('tanggal_masuk');
            $table->dateTime('maksimal_penyimpanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan');
    }
};
