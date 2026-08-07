<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest as AdminStoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest as AdminUpdateRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\Admin\RoleResource as AdminRoleResource;
use App\Http\Resources\RoleResource;
use LaravelLang\Publisher\Console\Update;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;


class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('read_roles');
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create_roles');
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreRoleRequest $request)
    {
        //

        Gate::authorize('create-roles');

        $data = $request->all();

        $create = Role::create($data);

        $rolSucces = AdminRoleResource::make($create);

        session()->flash('swal', [
            'icon'  => 'success', // ojo: tenías 'sucess'
            'title' => 'Rol creado correctamente',
            'text'  => 'El rol fue creado',
        ]);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //

        Gate::authorize('read-roles');

        return view('admin.roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('update-roles');

        if ($role->id <= 5) {
            session()->flash('swal', [
                'icon'  => 'error', // ojo: tenías 'sucess'
                'title' => 'Error',
                'text'  => 'No puedes editar este error',
            ]);

            return redirect()->route('admin.roles.index');
        } else {
            return view('admin.roles.edit')->with('role', $role);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRoleRequest $request, Role $role)
    {
        //
        Gate::authorize('update-roles');

        $role->update($request->validated()); // usa fillable ['name'] en el modelo

        session()->flash('swal', [
            'icon'  => 'success', // ojo: tenías 'sucess'
            'title' => 'Rol actualizado correctamente',
            'text'  => 'El rol fue actualizado',
        ]);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //

        if ($role->id <= 5) {
            session()->flash('swal', [
                'icon'  => 'error', // ojo: tenías 'sucess'
                'title' => 'Error',
                'text'  => 'No puedes editar este error',
            ]);

            return redirect()->route('admin.roles.index');
        } else {

            $role->delete();

            session()->flash('swal', [
                'icon'  => 'success', // ojo: tenías 'sucess'
                'title' => 'Rol eliminado correctamente',
                'text'  => 'El rol fue eliminado',
            ]);

            return redirect()->route('admin.roles.index');
        }
    }
}