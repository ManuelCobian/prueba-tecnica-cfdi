<x-admin-layout title="Editar Usuario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],

    [
        'name' => 'Roles',
        'href' => route('admin.roles.index'),
    ],

    [
        'name' => 'Editar Rol',
    ],
]">

    <x-wire-card>

        <form action="{{ route('admin.roles.update', $role) }}" method="POST">

           
            @csrf

            @method('PUT')
           
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del Rol" value="{{ old('name', $role->name) }}" />

            <div class="flex justify-end mt-5">

                <x-wire-button type="submit" blue> Actualizar</x-wire-button>
            </div>
        </form>

    </x-wire-card>
</x-admin-layout>
