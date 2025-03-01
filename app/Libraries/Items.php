<?php

namespace App\Libraries;

use App\Models\Item;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Items {

    public function get_pagination()
    {
        $search = request('search');
        $sort_by = request('sort');
        $per_page = request('perPage') ?? 10;
        
        $item_model = Item::where(function (Builder $query) use ($search) {

                !empty($search)
                    && $query->where('name', 'like', "%{$search}%");
            });

        if ($sort_by) 
        {
            $item_model->orderBy($sort_by['column'], $sort_by['order']);
        }

        return $item_model->paginate($per_page)
            ->withQueryString();
    }
}