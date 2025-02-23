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
        return Inertia::render('Users', [
            'users' => $this->buildQuery()
        ]);
    }

    public function buildQuery() 
    {
        $search = request('search');
        $sortBy = request('sort');
        
        $user = User::where('id', '!=', auth()->user()->id)
            ->where(function (Builder $query) use ($search) {

                !empty($search)
                    && $query->where('name', 'like', "%{$search}%");
            });

        if ($sortBy) 
        {
            $sortKey = array_keys($sortBy)[0];
            $user->orderBy($sortKey, $sortBy[$sortKey]);
        }

        return $user->paginate(10)
            ->withQueryString();
    }
}