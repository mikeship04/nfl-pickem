<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\User;

class ContestSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create();
        }

        Contest::factory()
            ->count(10)
            ->make()
            ->each(function ($contest) use ($users) {
                $contest->created_by = $users->random()->id;
                $contest->save();
            });
    }
}

