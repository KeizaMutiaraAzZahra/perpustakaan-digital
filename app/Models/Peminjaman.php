<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; // sesuaikan dengan nama tabel di DB

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];

    // 🔹 Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // 🔹 Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}