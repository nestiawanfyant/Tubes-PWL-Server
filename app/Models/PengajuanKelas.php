<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanKelas extends Model
{
    protected $table = 'pengajuan_kelas';

    protected $fillable = [
        'kelas_id',
        'user_id',
        'essay'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
