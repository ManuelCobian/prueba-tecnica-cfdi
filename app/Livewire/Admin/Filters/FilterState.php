<?php

namespace App\Livewire\Admin\Filters;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class FilterState extends Component
{
   
    public array $form = [
        'search' => '',
    ];

    
    public array $tableFilters = [
        'search' => '',
    ];

    public int $tableKey = 1;

    public function mount(): void
    {
        $this->resetFilters();

        $this->tableFilters = $this->form;
    }

    public function search(): void
    {
        $this->validate([
            'form.search' => [
                'nullable',
                'string',
                'max:100',
            ],
        ], [
            'form.search.string' => 'El texto de búsqueda no es válido.',
            'form.search.max' => 'La búsqueda no puede superar los 100 caracteres.',
        ]);

        $this->tableFilters = [
            'search' => trim($this->form['search'] ?? ''),
        ];

        $this->tableKey++;
    }

    public function clear(): void
    {
        $this->resetValidation();

        $this->resetFilters();

        $this->tableFilters = $this->form;

        $this->tableKey++;
    }

    private function resetFilters(): void
    {
        $this->form = [
            'search' => '',
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.filters.filter-state');
    }
}