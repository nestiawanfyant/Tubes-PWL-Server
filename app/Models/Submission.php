<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submission';

    protected $fillable = [
        'tugas_kelas_id',
        'user_id',
        'file',
        'komentar',
        'nilai',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
