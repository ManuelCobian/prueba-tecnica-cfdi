<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;

class StatesTable extends DataTableComponent
{
    protected $model = State::class;

    public array $filters = [];

    public function mount(array $filters = []): void
    {   
        
        $this->filters = $filters;
       
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        $search = trim($this->filters['search'] ?? '');

        return State::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('cve_ent', 'like', '%' . $search . '%');
                });
            });
    }

   public function columns(): array
{
    return [
        Column::make("Id", "id")
            ->sortable(),

        Column::make("Cve ent", "cve_ent")
            ->sortable()
            ->searchable(),

        Column::make("Nombre", "name")
            ->sortable()
            ->searchable(),

        Column::make("Siglas", "abbreviation")
            ->sortable()
            ->searchable(),

        Column::make("Poblacion Total", "population_total")
            ->sortable()
            ->format(function ($value) {
                return number_format((int) $value);
            }),

        Column::make("Poblacion Femenina", "population_female")
            ->sortable()
            ->format(function ($value) {
                return number_format((int) $value);
            }),

        Column::make("Poblacion Masculina", "population_male")
            ->sortable()
            ->format(function ($value) {
                return number_format((int) $value);
            }),

        Column::make("Casas Habitadas", "inhabited_houses")
            ->sortable()
            ->format(function ($value) {
                return number_format((int) $value);
            }),

        Column::make("Acciones")
            ->label(function ($row) {
                return view('admin.actions', ['state' => $row]);
            }),
    ];
}
}
