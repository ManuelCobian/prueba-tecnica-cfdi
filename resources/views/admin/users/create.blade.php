<x-admin-layout title="Crear Usuario" :breadcrumbs="[
    [
        'name' => 'Nuevo Rol',
        'href' => route('admin.dashboard'),
    ],

    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],

    [
        'name' => 'Crear Usuario',
    ],
]">

    <x-wire-card>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="grid lg:grid-cols-2 gap-4">

                    <x-wire-input label="Nombre" name="name" title="Nombre del usuario"
                        placeholder="Ingrese el nombre del usuario" value="{{ old('name') }}" required />

                    <x-wire-input label="Correo electronico" name="email" title="Correo Electronico"
                        placeholder="Ingrese Correo Electronico" value="{{ old('email') }}" required />

                    <x-wire-input label="Contraseña" name="password" title="Contraseña" placeholder="Ingrese Contraseña"
                        type="password" required />


                    <x-wire-input label="Confirmar Contraseña" name="password_confirmation" title="Confirmar Contraseña"
                        placeholder="Confirmar Contraseña" type="password" required />
                    {{-- DNI  --}}

                </div>





                <x-wire-native-select label="Rol" name="role_id">
                    <option value="0">Seleccion Rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
                    @endforeach
                </x-wire-native-select>

            
                <div class="flex justify-end mt-5">

                    <x-wire-button type="submit"> Guardar</x-wire-button>
                </div>

            </div>


        </form>

    </x-wire-card>


</x-admin-layout>
