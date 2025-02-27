<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $validated = $request->validateWithBag('create', [
            'name' => 'required|string',
            'roles' => 'required|exists:roles,code',
            'email' => 'required|string|lowercase|email|max:255',
            'password' => 'required|confirmed'
        ]);

        $data = $validated->all();

        $created_user = $this->user_lib->create($data);

        $message = $created_user
            ? 'User created successfuly!'
                : 'Failed creating user!';

        return redirect()
            ->route('user.index')
            ->with('message', $message);
    }

    public function update(Request $request)
    {
        $validated = $request->validateWithBag('create', [
            'name' => 'required|string',
            'roles' => 'required|exists:roles,code',
            'email' => 'required|string|lowercase|email|max:255',
            'password' => 'required|confirmed'
        ]);

        $data = $validated->all();

        $updated_user = $this->user_lib->update($data);

        $ret = redirect()->route('user.index');

        $message = $updated_user
            ? 'User updated successfuly!'
                : 'Failed updating user!';

        return redirect()
            ->route('user.index')
            ->with('message', $message);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validateWithBag('create', [
            'id' => 'required|number'
        ]);

        $data = $this->user_lib->delete($validated->id);

        $message = $data
            ? 'User deleted successfuly!'
                : 'Failed deleting user!';

        return redirect()
            ->route('user.index')
            ->with('message', $message);
    }
}