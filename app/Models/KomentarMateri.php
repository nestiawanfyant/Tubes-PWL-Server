<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarMateri extends Model
{
    protected $table = 'komentar_materi';

    protected $fillable = [
        'materi_id',
        'user_id',
        'komentar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
