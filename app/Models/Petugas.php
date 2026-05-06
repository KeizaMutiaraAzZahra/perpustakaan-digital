<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'jenis_kelamin',
        'no_telepon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}