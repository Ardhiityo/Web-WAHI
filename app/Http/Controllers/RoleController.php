<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\RoleInterface;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct(private RoleInterface $roleRepository) {}

    public function index()
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        $users = $this->roleRepository->getAllRoles();

        return view('pages.role.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.role.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();

        User::create($data)->assignRole($data['role']);

        return redirect()->route('roles.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(User $role)
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.role.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, User $role)
    {
        $data = $request->validated();

        $this->roleRepository->updateRole($role, $data);

        return redirect()->route('roles.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(User $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->withSuccess('Berhasil dihapus');
    }
}
