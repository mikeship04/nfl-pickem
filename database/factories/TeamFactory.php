<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;

class TeamFactory extends Factory
{
    protected $model = \App\Models\Team::class;
    
    protected static $teamIndex = 0;
    protected $teams = [
        ['name' => 'Arizona Cardinals', 'abbreviation' => 'ARI'],
        ['name' => 'Atlanta Falcons', 'abbreviation' => 'ATL'],
        ['name' => 'Baltimore Ravens', 'abbreviation' => 'BAL'],
        ['name' => 'Buffalo Bills', 'abbreviation' => 'BUF'],
        ['name' => 'Carolina Panthers', 'abbreviation' => 'CAR'],
        ['name' => 'Chicago Bears', 'abbreviation' => 'CHI'],
        ['name' => 'Cincinnati Bengals', 'abbreviation' => 'CIN'],
        ['name' => 'Cleveland Browns', 'abbreviation' => 'CLE'],
        ['name' => 'Dallas Cowboys', 'abbreviation' => 'DAL'],
        ['name' => 'Denver Broncos', 'abbreviation' => 'DEN'],
        ['name' => 'Detroit Lions', 'abbreviation' => 'DET'],
        ['name' => 'Green Bay Packers', 'abbreviation' => 'GB'],
        ['name' => 'Houston Texans', 'abbreviation' => 'HOU'],
        ['name' => 'Indianapolis Colts', 'abbreviation' => 'IND'],
        ['name' => 'Jacksonville Jaguars', 'abbreviation' => 'JAX'],
        ['name' => 'Kansas City Chiefs', 'abbreviation' => 'KC'],
        ['name' => 'Las Vegas Raiders', 'abbreviation' => 'LV'],
        ['name' => 'Los Angeles Chargers', 'abbreviation' => 'LAC'],
        ['name' => 'Los Angeles Rams', 'abbreviation' => 'LAR'],
        ['name' => 'Miami Dolphins', 'abbreviation' => 'MIA'],
        ['name' => 'Minnesota Vikings', 'abbreviation' => 'MIN'],
        ['name' => 'New England Patriots', 'abbreviation' => 'NE'],
        ['name' => 'New Orleans Saints', 'abbreviation' => 'NO'],
        ['name' => 'New York Giants', 'abbreviation' => 'NYG'],
        ['name' => 'New York Jets', 'abbreviation' => 'NYJ'],
        ['name' => 'Philadelphia Eagles', 'abbreviation' => 'PHI'],
        ['name' => 'Pittsburgh Steelers', 'abbreviation' => 'PIT'],
        ['name' => 'San Francisco 49ers', 'abbreviation' => 'SF'],
        ['name' => 'Seattle Seahawks', 'abbreviation' => 'SEA'],
        ['name' => 'Tampa Bay Buccaneers', 'abbreviation' => 'TB'],
        ['name' => 'Tennessee Titans', 'abbreviation' => 'TEN'],
        ['name' => 'Washington Commanders', 'abbreviation' => 'WAS']
    ];

    public function definition(): array
    {
        static $teamId = 100;

        return [
            'id' => $teamId++,
            'name' => $this->faker->unique()->company,
            'abbreviation' => $this->faker->unique()->lexify('???'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function reset(): void
    {
        static::$teamIndex = 0;
    }
}

