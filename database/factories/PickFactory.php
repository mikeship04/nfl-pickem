<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Matchup;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PickFactory extends Factory
{
    protected $model = \App\Models\Pick::class;

    public function definition(): array
    {
        $teams = Team::factory()->count(2)->create();
        $contest = Contest::factory()->create();
        $matchup = Matchup::factory()->create([
            'contest_id' => $contest->id,
            'team_1' => $teams[0]->id,
            'team_2' => $teams[1]->id
        ]);

        return [
            'user_id' => User::factory(),
            'contest_id' => $contest->id,
            'matchup_id' => $matchup->id,
            'team_id' => $this->faker->randomElement([$teams[0]->id, $teams[1]->id]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

