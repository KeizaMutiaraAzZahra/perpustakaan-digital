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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable(); 
            $table->date('jatuh_tempo');
            $table->enum('status', ['Diproses', 'Dipinjam', 'Menunggu Konfirmasi', 'Kembali', 'Terlambat', 'Selesai'])->default('Diproses');
            $table->integer('denda')->default(0);
            $table->integer('jumlah')->default(1);
            $table->string('status_denda')->default('belum_lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
