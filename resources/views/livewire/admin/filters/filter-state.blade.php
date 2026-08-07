
<div class="space-y-6">

    {{-- Filtro de búsqueda --}}
    <section
        class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        {{-- Decoración --}}
        <div
            class="pointer-events-none absolute -right-12 -top-12 h-40 w-40 rounded-full bg-blue-600/10 blur-3xl"
        ></div>

        <form wire:submit.prevent="search">
            <div class="relative p-5 sm:p-6">

                {{-- Encabezado --}}
                <div class="mb-6 flex items-start gap-4">

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 ring-1 ring-blue-100"
                    >
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                            Consulta
                        </p>

                        <h2 class="mt-1 text-xl font-bold text-slate-950">
                            Buscar estados
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Escribe el nombre o la clave del estado.
                        </p>
                    </div>
                </div>

                {{-- Contenedor del filtro --}}
                <div
                    class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 sm:p-5"
                >
                    <div
                        class="grid grid-cols-1 gap-5 lg:grid-cols-12 lg:items-end"
                    >

                        {{-- Campo de búsqueda --}}
                        <div class="lg:col-span-8">

                            <label
                                for="state_search"
                                class="mb-2 block text-sm font-semibold text-slate-800"
                            >
                                Nombre o clave del estado
                            </label>

                            <div class="relative">

                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                                >
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>

                                <input
                                    id="state_search"
                                    type="text"
                                    wire:model="form.search"
                                    wire:loading.attr="disabled"
                                    wire:target="search,clear"
                                    placeholder="Ejemplo: col, Colima, 06..."
                                    autocomplete="off"
                                    class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-11 text-sm text-slate-700 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:opacity-70"
                                >

                                {{-- Limpiar campo rápidamente --}}
                                @if (!empty($form['search']))
                                    <button
                                        type="button"
                                        wire:click="$set('form.search', '')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-blue-700"
                                        title="Limpiar campo"
                                    >
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </button>
                                @endif

                            </div>

                            @error('form.search')
                                <p
                                    class="mt-2 flex items-center gap-2 text-sm font-medium text-red-600"
                                >
                                    <i class="fa-solid fa-circle-exclamation"></i>

                                    <span>
                                        {{ $message }}
                                    </span>
                                </p>
                            @enderror

                        </div>

                        {{-- Botones --}}
                        <div
                            class="flex flex-col gap-3 sm:flex-row lg:col-span-4 lg:justify-end"
                        >

                            {{-- Limpiar --}}
                            <button
                                type="button"
                                wire:click="clear"
                                wire:loading.attr="disabled"
                                wire:target="clear"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-60 sm:min-w-32"
                            >

                                <span wire:loading.remove wire:target="clear">
                                    <i class="fa-solid fa-eraser text-blue-700"></i>
                                </span>

                                <span wire:loading wire:target="clear">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                </span>

                                <span wire:loading.remove wire:target="clear">
                                    Limpiar
                                </span>

                                <span wire:loading wire:target="clear">
                                    Limpiando...
                                </span>

                            </button>

                            {{-- Buscar --}}
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="search"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-700/20 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-800 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-60 sm:min-w-32"
                            >

                                <span wire:loading.remove wire:target="search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>

                                <span wire:loading wire:target="search">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                </span>

                                <span wire:loading.remove wire:target="search">
                                    Buscar
                                </span>

                                <span wire:loading wire:target="search">
                                    Buscando...
                                </span>

                            </button>

                        </div>

                    </div>
                </div>
            </div>
        </form>
    </section>


    {{-- Encabezado catálogo --}}
    <section
        class="relative overflow-hidden flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 lg:flex-row lg:items-center lg:justify-between"
    >

        {{-- Línea corporativa --}}
        <div class="absolute left-0 top-0 h-full w-1 bg-blue-700"></div>

        <div class="flex items-center gap-4">

            <div
                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 ring-1 ring-blue-100"
            >
                <i class="fa-solid fa-map-location-dot text-xl"></i>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                    Catálogos
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    Catálogo de Estados de México
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta los estados registrados en el sistema.
                </p>
            </div>

        </div>

        {{-- Indicador filtro --}}
        @if (!empty($tableFilters['search']))

            <div
                class="inline-flex items-center gap-2 self-start rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 lg:self-auto"
            >
                <i class="fa-solid fa-filter"></i>

                <span>
                    Búsqueda: “{{ $tableFilters['search'] }}”
                </span>
            </div>

        @else

            <div
                class="inline-flex items-center gap-2 self-start rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 lg:self-auto"
            >
                <i class="fa-solid fa-earth-americas"></i>

                <span>
                    Todos los estados
                </span>
            </div>

        @endif

    </section>


    {{-- Tabla --}}
    <section
        class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        wire:loading.class="pointer-events-none"
        wire:target="search,clear"
    >

        {{-- Header de tabla --}}
        <div
            class="flex flex-col gap-4 border-b border-slate-200 bg-slate-50/60 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700 ring-1 ring-blue-100"
                >
                    <i class="fa-solid fa-table-list"></i>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900">
                        Resultados encontrados
                    </h3>

                    <p class="text-sm text-slate-500">
                        Estados que coinciden con la búsqueda.
                    </p>
                </div>

            </div>

            {{-- Estado de carga --}}
            <div
                wire:loading.flex
                wire:target="search,clear"
                class="items-center gap-2 self-start rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-xs font-bold text-blue-700 sm:self-auto"
            >
                <i class="fa-solid fa-spinner fa-spin"></i>

                <span wire:loading wire:target="search">
                    Buscando...
                </span>

                <span wire:loading wire:target="clear">
                    Actualizando...
                </span>
            </div>

        </div>


        {{-- Contenido tabla --}}
        <div
            wire:loading.class="opacity-25 blur-[1px]"
            wire:target="search,clear"
            class="transition-all duration-300"
        >

            <div
                wire:key="states-table-container-{{ $tableKey }}"
                class="animate-table-entry p-4"
            >
                @livewire(
                    'admin.datatables.states-table',
                    ['filters' => $tableFilters],
                    key('states-table-' . $tableKey)
                )
            </div>

        </div>


        {{-- Overlay de carga --}}
        <div
            wire:loading.flex
            wire:target="search,clear"
            class="absolute inset-0 z-50 min-h-[320px] items-center justify-center bg-white/85 backdrop-blur-sm"
        >

            <div class="flex flex-col items-center px-6 py-12 text-center">

                {{-- Loader --}}
                <div class="relative mb-6 flex h-24 w-24 items-center justify-center">

                    {{-- Pulso --}}
                    <div
                        class="absolute inset-0 animate-ping rounded-full bg-blue-600/10"
                    ></div>

                    {{-- Spinner --}}
                    <div
                        class="absolute inset-2 animate-spin rounded-full border-4 border-slate-200 border-t-blue-700"
                    ></div>

                    {{-- Icono --}}
                    <div
                        class="relative flex h-14 w-14 items-center justify-center rounded-full bg-blue-700 text-white shadow-lg shadow-blue-700/30"
                    >

                        <span wire:loading wire:target="search">
                            <i class="fa-solid fa-magnifying-glass text-xl"></i>
                        </span>

                        <span wire:loading wire:target="clear">
                            <i class="fa-solid fa-rotate-left text-xl"></i>
                        </span>

                    </div>

                </div>


                {{-- Texto búsqueda --}}
                <div wire:loading wire:target="search">

                    <h3 class="text-lg font-bold text-slate-900">
                        Buscando estados
                    </h3>

                    <p class="mt-2 max-w-sm text-sm leading-6 text-slate-500">
                        Estamos buscando estados que coincidan con
                        “{{ $form['search'] ?? '' }}”.
                    </p>

                </div>


                {{-- Texto limpiar --}}
                <div wire:loading wire:target="clear">

                    <h3 class="text-lg font-bold text-slate-900">
                        Actualizando información
                    </h3>

                    <p class="mt-2 max-w-sm text-sm leading-6 text-slate-500">
                        Estamos limpiando la búsqueda y cargando todos los estados.
                    </p>

                </div>

            </div>

        </div>

    </section>


    @once
        @push('styles')
            <style>
                @keyframes tableEntry {
                    0% {
                        opacity: 0;
                        transform: translateY(14px);
                    }

                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-table-entry {
                    animation: tableEntry 0.45s ease-out;
                }
            </style>
        @endpush
    @endonce

</div>

