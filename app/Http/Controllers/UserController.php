<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Users', [
            'users' => $this->buildQuery()
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function buildQuery() 
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