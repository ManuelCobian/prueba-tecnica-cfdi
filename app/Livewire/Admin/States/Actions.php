<?php

namespace App\Livewire\Admin\States;

use Livewire\Component;
use App\Models\State;

class Actions extends Component
{


    public State $state;

    public function  mount(State $state)
    {
        $this->state  = $state;
    }

    public function render()
    {
        return view('livewire.admin.states.actions');
    }
}
