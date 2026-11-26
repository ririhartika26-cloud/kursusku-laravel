<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $users = User::orderBy('role')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'created_at']);

        return view('admin.users.index', compact('users'));
    }
}
