<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'nama', 
        'kelas', 
        'jurusan', 
        'no_telepon', 
        'username', 
        'password', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
