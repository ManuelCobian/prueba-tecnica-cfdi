<div>

    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-4">

            <div
                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 ring-1 ring-blue-100">

                <i class="fa-solid fa-map-location-dot text-xl"></i>

            </div>

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                    Catálogos
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    Municipios del estado {{ $state->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Consulta los municipios del estado {{ $state->name }}.
                </p>

            </div>

        </div>

        <div class="flex flex-wrap items-center gap-3">

            <span
                class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-200">

                <i class="fa-solid fa-location-dot"></i>

                {{ $this->municipalityCount }} municipios

            </span>

            <a href="{{ route('admin.dashboard') }}" wire:navigate
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-400 hover:bg-slate-50">

                <i class="fa-solid fa-arrow-left"></i>

                Volver

            </a>

        </div>

    </div>

    @if ($error)
        <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 p-4">

            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">

                    <i class="fa-solid fa-circle-exclamation"></i>

                </div>

                <div>

                    <p class="font-semibold text-red-800">
                        Error al consultar INEGI
                    </p>

                    <p class="mt-1 text-sm text-red-600">
                        {{ $error }}
                    </p>

                </div>

            </div>

        </div>
    @endif

    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div
            class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h3 class="flex items-center gap-2 font-semibold text-slate-900">

                    <i class="fa-solid fa-city text-blue-600"></i>

                    Municipios

                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Información obtenida del Marco Geoestadístico de INEGI.
                </p>

            </div>


            {{-- RECARGAR --}}
            <button type="button" wire:click="loadMunicipalities" wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50">

                <span wire:loading.remove wire:target="loadMunicipalities">

                    <i class="fa-solid fa-rotate"></i>

                    Actualizar

                </span>


                <span wire:loading wire:target="loadMunicipalities" class="flex items-center gap-2">

                    <i class="fa-solid fa-circle-notch animate-spin"></i>

                    Consultando...

                </span>

            </button>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                    <tr>

                        <th class="whitespace-nowrap px-5 py-3">
                            Clave
                        </th>

                        <th class="whitespace-nowrap px-5 py-3">
                            Municipio
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-right">
                            Población
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-right">
                            Mujeres
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-right">
                            Hombres
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-right">
                            Viviendas
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($paginatedMunicipalities as $municipality)
                        <tr wire:key="municipality-{{ $municipality['cvegeo'] ?? $loop->index }}"
                            class="transition hover:bg-slate-50">
                            
                            <td class="whitespace-nowrap px-5 py-4">

                                <span
                                    class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1 font-mono text-xs font-semibold text-slate-600">

                                    {{ $municipality['cve_mun'] ?? '---' }}

                                </span>

                            </td>

                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 ring-1 ring-blue-100">

                                        <i class="fa-solid fa-city"></i>

                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-900">

                                            {{ $municipality['nomgeo'] ?? 'Sin nombre' }}

                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">

                                            CVEGEO:
                                            {{ $municipality['cvegeo'] ?? '---' }}

                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-right font-medium text-slate-700">

                                {{ number_format((int) ($municipality['pob_total'] ?? 0)) }}

                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-right text-slate-600">

                                {{ number_format((int) ($municipality['pob_femenina'] ?? 0)) }}

                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-right text-slate-600">

                                {{ number_format((int) ($municipality['pob_masculina'] ?? 0)) }}

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-right text-slate-600">

                                {{ number_format((int) ($municipality['total_viviendas_habitadas'] ?? 0)) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-5 py-16 text-center">

                                <div
                                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                    <i class="fa-solid fa-map-location-dot text-2xl"></i>

                                </div>

                                <p class="mt-4 font-semibold text-slate-700">
                                    No se encontraron municipios
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    No hay información disponible para este estado.
                                </p>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}
        @if ($paginatedMunicipalities->hasPages())

            <div class="border-t border-slate-200 bg-slate-50/50 px-5 py-4">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">


                    {{-- INFORMACIÓN --}}
                    <div class="text-sm text-slate-500">

                        Mostrando

                        <span class="font-semibold text-slate-700">
                            {{ $paginatedMunicipalities->firstItem() }}
                        </span>

                        a

                        <span class="font-semibold text-slate-700">
                            {{ $paginatedMunicipalities->lastItem() }}
                        </span>

                        de

                        <span class="font-semibold text-slate-700">
                            {{ $paginatedMunicipalities->total() }}
                        </span>

                        municipios

                    </div>


                    {{-- LINKS --}}
                    <div>

                        {{ $paginatedMunicipalities->links() }}

                    </div>

                </div>

            </div>
        @else
            @if ($paginatedMunicipalities->total() > 0)
                <div class="border-t border-slate-200 bg-slate-50/50 px-5 py-4">

                    <p class="text-sm text-slate-500">

                        Mostrando

                        <span class="font-semibold text-slate-700">

                            {{ $paginatedMunicipalities->total() }}

                        </span>

                        municipios.

                    </p>

                </div>
            @endif

        @endif

    </div>

</div>
