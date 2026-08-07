<x-admin-layout title="Usuarios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],

    [
        'name' => 'Usuarios',
    ],
]">
@php
     $user = auth()->user();
@endphp
    <x-slot name="action">
        @if ($user->hasRole('SuperUsuario') || $user->hasRole('Recepcionista') || $user->hasRole('Administrador'))
           <x-wire-button href="{{ route('admin.users.create') }}" blue>
            <i class="fa-solid fa-plus"></i> Nuevo
        </x-wire-button>     
        @endif
        

    </x-slot>

    @livewire('admin.datatables.user-table')


</x-admin-layout>
