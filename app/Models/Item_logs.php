<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_logs extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'action',
        'description',
        'old_values',
        'new_values'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function item()
    {
        return $this->hasOne(Item::class);
    }
}
