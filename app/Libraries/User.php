<?php

namespace App\Libraries;

use App\Models\User as UserModel;
use Illuminate\Contracts\Database\Eloquent\Builder;

class User {

    public function create($data)
    {
        dd('create');
        return false;
    }

    public function get_paginated_users()
    {
        $search = request('search');
        $sort_by = request('sort');
        $per_page = request('perPage') ?? 10;
        
        $user = UserModel::with(['roles'])
            ->where('id', '!=', auth()->user()->id)
            ->where(function (Builder $query) use ($search) {

                !empty($search)
                    && $query->where('name', 'like', "%{$search}%");
            });

        if ($sort_by) 
        {
            $user->orderBy($sort_by['column'], $sort_by['order']);
        }

        return $user->paginate($per_page)
            ->withQueryString();
    }
}