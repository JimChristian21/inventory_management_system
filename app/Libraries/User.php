<?php

namespace App\Libraries;

use App\Models\User as UserModel;
use App\Models\User_role;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User {

    public function create($data): mixed
    {
        $ret = FALSE;

        DB::transaction(function () use ($data, &$ret) {

            $user = UserModel::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password)
            ]);
            
            $user
                && User_role::create([
                    'user_id' => $user->id,
                    'role_code' => $data->roles
                ]);

            $ret = User::find($user->id)
                ->with('roles')
                ->get();
        });
        
        return $ret;
    }

    public function update($data): mixed
    {
        $ret = FALSE;

        DB::transaction(function () use ($data, &$ret) {

            $user = UserModel::find($data->id);

            if ($user) 
            {
                unset($data->id);

                foreach($data as $attribute => $value) 
                {
                    property_exists($user, $attribute)
                        && $user->{$attribute} != $value
                        && $user->{$attribute} = $value;

                    if ($user->isDirty())
                    {
                        $user->save();
                        $ret = TRUE;
                    }
                }
            }
        });
        
        return $ret;
    }

    public function delete(int $id)
    {
        $ret = FALSE;

        DB::transaction(function() use ($id, &$ret) {

            $ret = UserModel::destroy($id);
        });

        return $ret;
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