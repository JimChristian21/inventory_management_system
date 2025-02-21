<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'critical_quantity'
    ];

    public function item_logs()
    {
        return $this->belongsTo(Item_logs::class);
    }
}
