<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
        'kode',
        'tipe'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->hasMany(RoleKelas::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(PengajuanKelas::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
