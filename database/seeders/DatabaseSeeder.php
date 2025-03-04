<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->command->info('Seeding users...');
            $this->call(UserSeeder::class);

            $this->command->info('Seeding teams...');
            $this->call(TeamSeeder::class);

            $this->command->info('Seeding contests...');
            $this->call(ContestSeeder::class);

            $this->command->info('Seeding matchups...');
            $this->call(MatchupSeeder::class);

            $this->command->info('Seeding picks...');
            $this->call(PickSeeder::class);
        });
    }
}

