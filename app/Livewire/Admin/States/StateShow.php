<?php

namespace App\Livewire\Admin\States;

use App\Models\State;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class StateShow extends Component
{
    use WithPagination;

    public State $state;

    public array $municipalities = [];

    public ?string $error = null;

    public bool $loadingMunicipalities = false;

    public int $perPage = 10;

    public function mount(State $state): void
    {
        $this->state = $state;

        $this->loadMunicipalities();
    }

    public function loadMunicipalities(): void
    {
        $this->loadingMunicipalities = true;

        try {

            $cveEnt = str_pad(
                (string) $this->state->cve_ent,
                2,
                '0',
                STR_PAD_LEFT
            );

            $response = Http::timeout(15)
                ->acceptJson()
                ->get(
                    "https://gaia.inegi.org.mx/wscatgeo/v2/mgem/{$cveEnt}"
                );

            if (!$response->successful()) {

                $this->municipalities = [];

                $this->error = 'No fue posible consultar los municipios en INEGI.';

                return;
            }

            $this->municipalities = $response->json('datos') ?? [];

            $this->municipalities = collect($this->municipalities)
                ->sortBy(function ($municipality) {
                    return (int) ($municipality['cve_mun'] ?? 0);
                })
                ->values()
                ->toArray();

            $this->error = null;

            $this->resetPage();

        } catch (\Throwable $e) {

            report($e);

            $this->municipalities = [];

            $this->error = 'Ocurrió un error al consultar el servicio de INEGI.';

        } finally {

            $this->loadingMunicipalities = false;
        }
    }

    public function getPaginatedMunicipalitiesProperty(): LengthAwarePaginator
    {
        $page = $this->getPage();

        $items = collect($this->municipalities);

        return new LengthAwarePaginator(
            $items
                ->forPage($page, $this->perPage)
                ->values(),
            $items->count(),
            $this->perPage,
            $page,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
    }

    public function getMunicipalityCountProperty(): int
    {
        return count($this->municipalities);
    }

    public function render()
    {
        return view('livewire.admin.states.state-show', [
            'paginatedMunicipalities' => $this->paginatedMunicipalities,
        ]);
    }
}