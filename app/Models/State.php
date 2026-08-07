<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $table = "estados";

    public $timestamps = false;

    protected $fillable = [
       'cve_ent',
       'name',
       'abbreviation',
       'population_total',
       'population_female',
       'population_male',
       'inhabited_houses',  
    ];
}
