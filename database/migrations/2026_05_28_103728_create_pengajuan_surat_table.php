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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
    $table->id();

    $table->foreignId('mahasiswa_id')
          ->constrained('mahasiswa')
          ->onDelete('cascade');

    $table->foreignId('jenis_surat_id')
          ->constrained('jenis_surat')
          ->onDelete('cascade');

    $table->string('status')->default('pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
