<?php

namespace App\Http\Controllers;
use App\Models\State;
use App\Http\Controllers\Admin\BaseController as AdminBaseController;

class HomeController extends AdminBaseController
{ 
    public function index()
    {
       
        if (! State::exists()) {
            $this->statesService->import();
        }

        return view('admin.dashboard');
    }

    public function detail(State $state)
    {
       return view('admin.states.show',compact("state"));
    }
}
