<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\Repository\UsersRepository;
use Inertia\Inertia;

class Users extends Controller
{
    protected $users_repository;

    public function __construct() 
    {
        $this->users_repository = new UsersRepository();
    }
    
    public function index()
    {
        $users = $this->users_repository->get_pagination();

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

        $created_user = $this->users_repository->create((object) $validated);

        $message = $created_user
            ? 'User created successfuly!'
                : 'Failed creating user!';
            
        $o = (object) [
            'status' => $created_user ? 'S' : 'E',
            'message' => $message
        ];

        return redirect()
            ->route('user.index')
            ->with('message', $o);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validateWithBag('update', [
            'name' => 'required|string',
            'roles' => 'required|exists:roles,code'
        ]);

        $updated_user = $this->users_repository->update($id, (object) $validated);

        $message = $updated_user
            ? 'User updated successfuly!'
                : 'Failed updating user!';

        $o = (object) [
            'status' => $updated_user ? 'S' : 'E',
            'message' => $message
        ];

        return redirect()
            ->route('user.index')
            ->with('message', $o);
    }

    public function destroy(Request $request, int $id)
    {
        $is_deleted = $this->users_repository->delete($id);

        $message = $is_deleted
            ? 'User deleted successfuly!'
                : 'Failed deleting user!';

        $o = (object) [
            'status' => $is_deleted ? 'S' : 'E',
            'message' => $message
        ];

        return redirect()
            ->route('user.index')
            ->with('message', $o);
    }
}