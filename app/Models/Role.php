<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'code';
    protected $fillable = [
        'code',
        'name'
    ];
    public $incrementing = false;
    public $timestamps = false;

    public function user_role()
    {
        return $this->hasMany(User_role::class);
    }
}
