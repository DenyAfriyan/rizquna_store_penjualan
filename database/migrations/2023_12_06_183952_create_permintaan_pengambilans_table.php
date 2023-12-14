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
        Schema::create('permintaan_pengambilan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_limbah_id')->constrained(table:'jenis_limbah');
            $table->foreignId('sumber_limbah_id')->constrained(table:'sumber_limbah');
            $table->text('notes')->nullable();
            $table->integer('is_approved')->default(0);
            $table->integer('is_noted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_pengambilan');
    }
};
