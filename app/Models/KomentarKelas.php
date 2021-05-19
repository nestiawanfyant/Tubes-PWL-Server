<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarKelas extends Model
{
    protected $table = 'komentar_kelas';

    protected $fillable = [
        'kelas_id',
        'user_id',
        'komentar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
