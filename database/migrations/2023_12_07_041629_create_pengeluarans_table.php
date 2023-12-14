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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_limbah_id')->constrained(table:'jenis_limbah');
            $table->foreignId('vendor_id')->constrained(table:'vendors');
            $table->foreignId('sisa_id')->constrained(table:'sisa');
            $table->integer('jumlah_limbah_keluar');
            $table->string('bukti_nomor_dokumen');
            $table->dateTime('tanggal_keluar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
