<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->withCount('appointments')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $appointments = $user->appointments()->latest()->paginate(10);

        return view('admin.users.show', compact('user', 'appointments'));
    }
}
