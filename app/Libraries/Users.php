<?php

namespace App\Libraries;

use App\Models\User;
use App\Models\User_role;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Users {

    public function create(object $data): mixed
    {
        $ret = FALSE;

        DB::transaction(function () use ($data, &$ret) {

            $user = User::create([
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

    public function update($id, $data): mixed
    {
        $ret = FALSE;

        DB::transaction(function () use ($id, $data, &$ret) {

            $user = User::find($id);

            if ($user) 
            {
                $user->name = $data->name;
                
                $user_role = User_role::where('user_id', '=', $user->id)
                    ->where('role_code', '=', $user->roles[0]->code)
                    ->get()[0];

                if ($user_role) {

                    $user_role->role_code = $data->roles;
                    
                    $user->save()
                        && $user_role->save()
                        && $ret = TRUE;
                }
            }
        });
        
        return $ret;
    }

    public function delete(int $id)
    {
        $ret = FALSE;

        DB::transaction(function() use ($id, &$ret) {

            $user = $this->get_user($id);

            $user
                && $user->delete()
                && $ret = TRUE;
        });

        return $ret;
    }

    public function get_user($id)
    {
        return User::find($id);
    }

    public function get_pagination()
    {
        $search = request('search');
        $sort_by = request('sort');
        $per_page = request('perPage') ?? 10;
        
        $user = User::with(['roles'])
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