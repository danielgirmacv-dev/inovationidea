<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,reviewer,employee'],
            'department' => ['nullable', 'string', 'max:255'],
            'site' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'job_title' => ['nullable', 'string', 'max:255'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return back()->with('success', 'User created successfully.');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'You cannot deactivate your own account.']);
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', 'User status updated.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => ['required', 'in:admin,reviewer,employee']]);

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role updated to {$request->role}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return back()->with('success', "User \"{$user->name}\" has been deleted.");
    }
}
