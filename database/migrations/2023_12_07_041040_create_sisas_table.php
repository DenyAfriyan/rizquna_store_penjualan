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
        Schema::create('sisa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_limbah_id')->constrained(table:'jenis_limbah');
            $table->integer('sisa_akhir')->default(0);
            $table->enum('jenis_transaksi',['Penerimaan','Pengeluaran']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisa');
    }
};
