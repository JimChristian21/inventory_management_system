<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    protected $fillable = [
        'user_id',
        'role_code'
    ];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
