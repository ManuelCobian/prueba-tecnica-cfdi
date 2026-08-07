<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Throwable;
use App\Http\Controllers\Admin\BaseController as AdminBaseController;
use App\Models\State;

class StatesController extends AdminBaseController
{
    public function import(): void
    {
        $baseUrl = rtrim(config('services.inegi.host'), '/');
        $response = Http::get($baseUrl);

        if (!$response->successful()) {
            return;
        }

        foreach ($response->json('datos') as $state) {
            $this->statesService->createState($state); 
        }
    }


    public function muns(State $state): void
    {
        $baseUrl = rtrim(config('services.inegi.host'), '/');
        $response = Http::get($baseUrl);

        if (!$response->successful()) {
            return;
        }

        foreach ($response->json('datos') as $state) {
            $this->statesService->createState($state); 
        }
    }
}
