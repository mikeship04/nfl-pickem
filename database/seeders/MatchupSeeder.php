<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matchup;
use App\Models\Contest;
use App\Models\Team;

class MatchupSeeder extends Seeder
{
    public function run(): void
    {
        $teams = Team::all();
        $contests = Contest::all();

        if ($teams->count() < 2) {
            $teams = Team::factory()->count(32)->create();
        }

        if ($contests->isEmpty()) {
            $contests = Contest::factory()->count(10)->create();
        }

        Matchup::factory()
            ->count(20)
            ->make()
            ->each(function ($matchup) use ($teams, $contests) {
                $matchup->contest_id = $contests->random()->id;

                // Ensure team_1 and team_2 are different
                do {
                    $team1 = $teams->random()->id;
                    $team2 = $teams->random()->id;
                } while ($team1 === $team2);

                $matchup->team_1 = $team1;
                $matchup->team_2 = $team2;

                // Assign a week value between 1 and 18
                $matchup->week = rand(1, 18);

                $matchup->save();
            });
    }
}



