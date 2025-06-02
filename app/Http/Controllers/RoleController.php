<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Database\Eloquent\Builder;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::with([
            'roles' =>
            fn(Builder $query) => $query->select('id', 'name')
        ])->paginate(perPage: 5);

        return view('pages.role.index', compact('users'));
    }

    public function create()
    {
        return view('pages.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ])->assignRole($request->role);

        return redirect()->route('roles.index');
    }

    public function edit(User $role)
    {
        return view('pages.role.edit', compact('role'));
    }

    public function show(User $role)
    {
        return view('pages.role.show', compact('role'));
    }

    public function update(Request $request, User $role)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $role->id,
            'password' => 'nullable|min:8',
        ]);

        $role->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => is_null($request->password) ? $role->password : Hash::make($request->password),
        ]);

        $role->removeRole($role->roles->first()->name);
        $role->assignRole($request->role);

        return redirect()->route('roles.index');
    }

    public function destroy(User $role)
    {
        $role->delete();
        return redirect()->route('roles.index');
    }
}
