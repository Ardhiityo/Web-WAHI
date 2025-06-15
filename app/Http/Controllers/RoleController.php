<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Interfaces\RoleInterface;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private RoleInterface $roleRepository) {}

    public function index()
    {
        $this->authorize('role.index');

        $users = $this->roleRepository->getAllRoles();

        return view('pages.role.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('role.create');

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
        $this->authorize('role.edit');

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
        $this->authorize('role.destroy');

        $role->delete();

        return redirect()->route('roles.index')->withSuccess('Berhasil dihapus');
    }
}
