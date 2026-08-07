<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\StatesController as StateController;
use App\Models\State;

class HomeController extends Controller
{
    public function __construct(
        protected StateController $stateController
    ) {}

    public function index()
    {
       
         if (! State::exists()) {
            $this->stateController->import();
        }

        return view('admin.dashboard');
    }

    public function detail(State $state)
    {
       return view('admin.states.show',compact("state"));
    }
}
