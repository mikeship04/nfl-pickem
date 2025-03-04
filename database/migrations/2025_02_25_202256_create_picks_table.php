<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('picks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contest_id')->constrained()->onDelete('cascade');
            $table->foreignId('matchup_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique picks per user per matchup
            $table->unique(['user_id', 'contest_id', 'matchup_id']);
            
            // Add a check constraint to ensure team_id is either team_1 or team_2 from matchup
            $table->foreign(['team_id', 'matchup_id'])
                ->references(['team_1', 'id'])
                ->on('matchups')
                ->orWhere(function ($query) {
                    $query->whereColumn('team_id', 'team_2');
                });
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('picks');
    }
};