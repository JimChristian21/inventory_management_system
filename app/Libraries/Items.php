<?php

namespace App\Libraries;

use App\Models\Item;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Items {

    public function create($data): mixed 
    {
        $ret = FALSE;
        
        DB::transaction(function() use ($data) {
            
            $ret = Item::create([
                'name' => $data->name,
                'description' => $data->description,
                'quantity' => $data->quantity,
                'critical_quantity' => $data->critical_quantity
            ]);
        });

        return $ret;
    }

    public function update(int $id, object $data): mixed
    {
        $ret = FALSE;

        if ($item = Item::find($id)) 
        {
            DB::transaction(function () use ($item, $data) {

                $item->name = $data->name;
                $item->description = $data->description;
                $item->quantity = $data->quantity;
                $item->critical_quantity = $data->critical_quantity;

                $ret = $item->save();
            });
        }

        return $ret;
    }

    public function delete(int $id): mixed
    {
        $ret = FALSE;

        if ($item = Item::find($id))
        {

            DB::transaction(function() use ($item, &$ret) {

                $ret = $item->delete();
            });
        }

        return $ret;
    }

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