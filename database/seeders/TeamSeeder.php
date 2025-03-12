<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $factory = Team::factory();
        
        $factory->reset();
        
        Team::factory()->count(32)->create();
    }
}

