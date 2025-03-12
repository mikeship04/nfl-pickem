<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatchupFactory extends Factory
{
    protected $model = \App\Models\Matchup::class;

    public function definition(): array
    {
        if (Team::count() === 0) {
            throw new \RuntimeException('No teams found in database. Please run TeamSeeder first.');
        }

        $teams = Team::inRandomOrder()->limit(2)->get();
        
        return [
            'contest_id' => Contest::factory(),
            'team_1' => $teams[0]->id,
            'team_2' => $teams[1]->id,
            'week' => $this->faker->numberBetween(1, 18),
            'active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}



