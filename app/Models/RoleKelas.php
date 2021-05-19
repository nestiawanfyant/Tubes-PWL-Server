<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleKelas extends Model
{
    protected $table = 'role_kelas';

    protected $fillable =
    [
        'kelas_id',
        'user_id',
        'role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
