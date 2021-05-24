<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas_kelas';

    protected $fillable = [
        'kelas_id',
        'user_id',
        'nama',
        'deskripsi',
        'file',
        'deadline',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submission()
    {
        return $this->hasMany(Submission::class);
    }

    public function komentar()
    {
        return $this->hasMany(KomentarTugas::class);
    }
}
