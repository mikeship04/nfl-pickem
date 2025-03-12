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
        if (Team::count() === 0) {
            $this->call(TeamSeeder::class);
        }
        $teams = Team::all();

        if (Contest::count() === 0) {
            $this->call(ContestSeeder::class);
        }
        $contests = Contest::all();

        foreach ($contests as $contest) {
            for ($week = 1; $week <= 18; $week++) {
                for ($i = 0; $i < 2; $i++) {
                    $matchupTeams = $teams->random(2);
                    
                    Matchup::create([
                        'contest_id' => $contest->id,
                        'week' => $week,
                        'team_1' => $matchupTeams[0]->id,
                        'team_2' => $matchupTeams[1]->id,
                        'active' => true
                    ]);
                }
            }
        }
    }
}



