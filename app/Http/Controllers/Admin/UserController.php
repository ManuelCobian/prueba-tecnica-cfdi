<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $user = User::create($data);
        $user->roles()->attach($data['role_id']);
        
         $isProviders = $user->roles()
            ->where('name', 'Proveedor') // o por id si lo conoces
            ->exists();

        if ($isProviders) {
            $user->providers()->create([
                'name' => $user->name,
                'user_id' => $user->id,
            ]);
            return redirect()->route('admin.providers.index');
        }

          session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Usuario creado correctamente',
            'text'  => 'El Usuario fue creado',
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        

        return view('admin.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
       
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);
       

        $user->update($data);

        if ($request->password) {

            $user->password = bcrypt($request->password);
            $user->save();
        }

        $user->roles()->sync($data['role_id']);

        session()->flash('swal', [
            'icon'  => 'success', // ojo: tenías 'sucess'
            'title' => 'Usuario Actualizado correctamente',
            'text'  => 'El Usuario fue actualizado',
        ]);


        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->roles()->detach();
        $user->delete();
        session()->flash('swal', [
            'icon'  => 'success', // ojo: tenías 'sucess'
            'title' => 'Usuario Eliminado correctamente',
            'text'  => 'El Usuario fue Eliminado',
        ]);

        return redirect()->route('admin.users.index', $user->id);
    }
}
