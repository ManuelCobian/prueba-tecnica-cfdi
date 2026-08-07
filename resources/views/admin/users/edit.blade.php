<x-admin-layout title="Editar Usuario" :breadcrumbs="[
    [
        'name' => 'Nuevo Rol',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Editar Usuario',
    ],
]">



    <x-wire-card>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="grid lg:grid-cols-2 gap-4">

                    <x-wire-input label="Nombre" name="name" title="Nombre del usuario"
                        placeholder="Ingrese el nombre del usuario" :value="old('name', $user->name)" required />

                    <x-wire-input label="Correo electrónico" name="email" title="Correo electrónico"
                        placeholder="Ingrese correo electrónico" :value="old('email', $user->email)" required />

                    <x-wire-input label="Contraseña" name="password" title="Contraseña"
                        placeholder="Ingrese contraseña (dejar en blanco para no cambiar)" type="password" />

                    <x-wire-input label="Confirmar contraseña" name="password_confirmation" title="Confirmar contraseña"
                        placeholder="Confirmar contraseña" type="password" />

            
                </div>

                <x-wire-native-select label="Rol" name="role_id">
                    <option value="0">Seleccione rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id', optional($user->roles->first())->id) == $role->id)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>
                
                <div class="flex justify-end mt-5">
                    <x-wire-button type="submit">Guardar</x-wire-button>
                </div>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
