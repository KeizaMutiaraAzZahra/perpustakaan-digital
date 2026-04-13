<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'jatuh_tempo',
        'tanggal_kembali',
        'status',
        'denda',
        'jumlah',
    ];

    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // Casting tanggal biar bisa pakai fungsi ->format() di Blade tanpa error
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'jatuh_tempo' => 'date',
        'tanggal_kembali' => 'date',
    ];

    // Opsional: Otomatis cek terlambat tiap kali data diakses
    public function getStatusLabelAttribute()
    {
        if ($this->status == 'Dipinjam' && $this->jatuh_tempo && Carbon::now()->gt($this->jatuh_tempo)) {
            return 'Terlambat';
        }
        return $this->status;
    }
}