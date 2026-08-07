<div
    class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:flex-row lg:items-center lg:justify-between">

    <div class="flex items-center gap-4">

        {{-- Icono --}}
        <div
            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 ring-1 ring-blue-100">
            <i class="fa-solid fa-clipboard-list text-xl"></i>
        </div>

        {{-- Información --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                Catálogos
            </p>

            <h2 class="mt-1 text-lg font-bold text-slate-900">
                Estados de México
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Gestiona el catálogo de Estados de México.
            </p>
        </div>

    </div>
</div>

<br>

<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    @livewire('admin.datatables.states-table')
</div>
