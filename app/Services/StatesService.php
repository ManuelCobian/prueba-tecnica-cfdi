<?php

namespace App\Services;

use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StatesService
{ 

 public function import(): void
 {
    $response = Http::timeout(15)
        ->retry(3, 500)
        ->acceptJson()
        ->get(config('services.inegi.host'));

        $response->throw();

        foreach ($response->json('datos', []) as $state) {
            $this->createState($state);
        }
}


  public function createState($data = []): State
  {
        return DB::transaction(function () use ($data) {
         $state = State::updateOrCreate(
                [
                    'cve_ent' => $data['cve_ent']
                ],
                [
                    'name' => $data['nomgeo'],
                    'abbreviation' => $data ['nom_abrev'],
                    'population_total' => $data['pob_total'],
                    'population_female' => $data['pob_femenina'],
                    'population_male' => $data['pob_masculina'],
                    'inhabited_houses' => $data['total_viviendas_habitadas'],
                ]
            );
            return $state;
        });
    }
}