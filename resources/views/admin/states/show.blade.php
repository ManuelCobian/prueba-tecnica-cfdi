<x-admin-layout title="Dashboard">
    <x-wire-card class="mb-8">
        

        @livewire('admin.states.state-show', ['state' => $state])
       
    </x-wire-card>

</x-admin-layout>