<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Account',
            'email' => 'adminaccount@gmail.com',
            'password' => bcrypt("12345678"),
        ])->assignRole('SuperUsuario');


         User::factory()->create([
            'name' => 'Guest Account',
            'email' => 'guestaccount@gmail.com',
            'password' => bcrypt("12345678"),
        ])->assignRole('Guest');
    }
}
