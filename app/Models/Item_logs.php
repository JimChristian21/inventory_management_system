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
}
