<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggotas';
    
    protected $fillable = [
        'user_id',    
        'nama', 
        'kelas', 
        'jurusan', 
        'no_telepon', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}