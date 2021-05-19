<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarTugas extends Model
{
    protected $table = 'komentar_tugas';

    protected $fillable = [
        'tugas_kelas_id',
        'user_id',
        'komentar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
