<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\StatesService;

class BaseController extends Controller
{
    public ?User $user;

    public ?StatesService $statesService;

    public function __construct(StatesService $statesService)
    {
        $this->user = auth()->user();
        $this->statesService = $statesService;
    }
}
