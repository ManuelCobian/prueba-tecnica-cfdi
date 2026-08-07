<x-admin-layout title="Nuevo" :breadcrumbs="[
    [
        'name' => 'Nuevo Rol',
        'href' => route('admin.dashboard'),
    ],

    [
        'name' => 'Roles',
        'href' => route('admin.roles.index'),
    ],

    [
        'name' => 'Crear Rol',
    ],
]">

    <x-wire-card>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del Rol" value="{{ old('name') }}" />

            <div class="flex justify-end mt-5">

                <x-wire-button type="submit" blue> Guardar</x-wire-button>
            </div>
        </form>

    </x-wire-card>


</x-admin-layout>
