<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'anggota_id', // Sudah diganti
        'buku_id',
        'tanggal_pinjam',
        'jatuh_tempo',
        'tanggal_kembali',
        'status',
        'denda'
    ];

    // Relasi ke Anggota
    public function anggota()
    {
        // Pastikan model Anggota.php sudah ada
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'jatuh_tempo' => 'datetime',
    ];
}