@php
    $user = auth()->user();
    $user->load('roles');

@endphp
<x-admin-layout title="Dashboard">
    <x-wire-card class="mb-8">
        

        @livewire('admin.filters.filter-state')
       
    </x-wire-card>

</x-admin-layout>
