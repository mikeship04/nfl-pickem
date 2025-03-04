<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pick;
use App\Models\User;
use App\Models\Contest;
use App\Models\Matchup;
use Illuminate\Support\Facades\DB;

class PickSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $users = User::all();
            $contests = Contest::with('matchups')->get();

            $picks = [];
            foreach ($users as $user) {
                foreach ($contests as $contest) {
                    $matchups = $contest->matchups->take(5);
                    foreach ($matchups as $matchup) {
                        $picks[] = [
                            'user_id' => $user->id,
                            'contest_id' => $contest->id,
                            'matchup_id' => $matchup->id,
                            'team_id' => rand(0, 1) ? $matchup->team_1 : $matchup->team_2,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
            
            // Bulk insert for better performance
            foreach (array_chunk($picks, 1000) as $chunk) {
                Pick::insert($chunk);
            }
        });
    }
}
