<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Libraries\User as UserLib;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $user_lib;

    public function __construct() 
    {
        $this->user_lib = new UserLib();
    }
    public function index()
    {
        $users = $this->user_lib->get_paginated_users();

        return Inertia::render('Users/Users', [
            'users' =>  $users
        ]);
    }

    public function store(Request $request)
    {
        // dd('store');
        $validated = $request->validateWithBag('create', [
            'name' => 'required|string',
            'roles' => 'required|exists:roles,code',
            'email' => 'required|string|lowercase|email|max:255',
            'password' => 'required|confirmed'
        ]);

        $data = $this->user_lib->create($validated);

        return NULL;
    }

    public function create()
    {
        dd('create_control');
    }
}