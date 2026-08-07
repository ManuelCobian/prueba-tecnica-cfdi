<?php

namespace App\Services;

use App\Models\State;
use Illuminate\Support\Facades\DB;

class StatesService
{ 


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