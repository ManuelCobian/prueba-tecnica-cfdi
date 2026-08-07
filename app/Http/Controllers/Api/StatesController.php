<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Admin\BaseController as AdminBaseController;

class StatesController extends AdminBaseController
{
    public function import(): void
    {
        $response = Http::timeout(15)
            ->retry(3, 500)
            ->acceptJson()
            ->get(config('services.inegi.host'));

        $response->throw();

        foreach ($response->json('datos', []) as $state) {
            $this->statesService->createState($state);
        }
    }
}
