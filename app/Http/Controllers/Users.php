<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\Users as UsersLib;
use Inertia\Inertia;

class Users extends Controller
{
    protected $users_lib;

    public function __construct() 
    {
        $this->users_lib = new UsersLib();
    }
    
    public function index()
    {
        $users = $this->users_lib->get_pagination();

        return Inertia::render('Users', [
            'users' =>  $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validateWithBag('create', [
            'name' => 'required|string',
            'roles' => 'required|exists:roles,code',
            'email' => 'required|string|lowercase|email|unique:users,email|max:255',
            'password' => 'required|confirmed'
        ]);

        $created_user = $this->users_lib->create((object) $validated);

        $message = $created_user
            ? 'User created successfuly!'
                : 'Failed creating user!';

        return redirect()
            ->route('user.index')
            ->with('message', $message);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validateWithBag('update', [
            'name' => 'required|string',
            'roles' => 'required|exists:roles,code'
        ]);

        $updated_user = $this->users_lib->update($id, (object) $validated);

        $message = $updated_user
            ? 'User updated successfuly!'
                : 'Failed updating user!';

        return redirect()
            ->route('user.index')
            ->with('message', $message);
    }

    public function destroy(Request $request, int $id)
    {
        $is_deleted = $this->users_lib->delete($id);

        $message = $is_deleted
            ? 'User deleted successfuly!'
                : 'Failed deleting user!';

        return redirect()
            ->route('user.index')
            ->with('message', $message);
    }
}