<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';
    
    protected $fillable = [
        'judul',
        'penulis',
        'tahun_terbit',
        'stok',
        'kategori',
        'gambar',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($buku) {
            if (empty($buku->stok)) {
                $buku->stok = 0;
            }
        });
    }
}
