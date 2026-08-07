<?php

namespace Tests\Feature;

use App\Services\StatesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InegiStatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_state_can_be_saved(): void
    {
        $data = [
            'cve_ent' => '01',
            'nomgeo' => 'Aguascalientes',
            'nom_abrev' => 'Ags.',
            'pob_total' => 1425607,
            'pob_femenina' => 728924,
            'pob_masculina' => 696683,
            'total_viviendas_habitadas' => 386671,
        ];

        $service = app(StatesService::class);

        $service->createState($data);

        $this->assertDatabaseHas('estados', [
            'cve_ent' => '01',
            'name' => 'Aguascalientes',
            'population_total' => 1425607,
        ]);
    }

    public function test_importing_the_same_state_twice_does_not_duplicate_it(): void
    {
        $data = [
            'cve_ent' => '01',
            'nomgeo' => 'Aguascalientes',
            'nom_abrev' => 'Ags.',
            'pob_total' => 1425607,
            'pob_femenina' => 728924,
            'pob_masculina' => 696683,
            'total_viviendas_habitadas' => 386671,
        ];

        $service = app(StatesService::class);

        $service->createState($data);

        $service->createState($data);

        $this->assertDatabaseCount('estados', 1);
    }

    public function test_importing_states_twice_is_idempotent(): void
    {
        $service = app(StatesService::class);

        $state = [
            'cve_ent' => '01',
            'nomgeo' => 'Aguascalientes',
            'nom_abrev' => 'Ags.',
            'pob_total' => 1425607,
            'pob_femenina' => 728924,
            'pob_masculina' => 696683,
            'total_viviendas_habitadas' => 386671,
        ];

        $service->createState($state);
        $service->createState($state);

        $this->assertDatabaseCount('estados', 1);

        $this->assertDatabaseHas('estados', [
            'cve_ent' => '01',
            'name' => 'Aguascalientes',
            'population_total' => 1425607,
        ]);
    }
}
