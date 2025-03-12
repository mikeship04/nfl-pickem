<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Matchup;
use App\Models\Team;
use App\Models\Contest;
use App\Models\Pick;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class MatchupTest extends TestCase
{
    use RefreshDatabase;

    private $matchup;
    private $teams;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teams = Team::factory()->count(2)->create();
        $this->matchup = Matchup::factory()->create([
            'team_1' => $this->teams[0]->id,
            'team_2' => $this->teams[1]->id
        ]);
    }

    #[Test]
    public function a_matchup_can_be_created()
    {
        $this->assertDatabaseHas('matchups', ['id' => $this->matchup->id]);
    }

    #[Test]
    public function a_matchup_belongs_to_a_contest()
    {
        $this->assertInstanceOf(Contest::class, $this->matchup->contest);
    }

    #[Test]
    public function matchup_has_two_different_teams()
    {
        $this->assertInstanceOf(Team::class, $this->matchup->teamOne);
        $this->assertInstanceOf(Team::class, $this->matchup->teamTwo);
        $this->assertNotEquals($this->matchup->team_1, $this->matchup->team_2);
    }

    #[Test]
    public function a_matchup_can_have_a_winner()
    {
        $this->matchup->winner = $this->teams[0]->id;
        $this->matchup->save();

        $this->assertInstanceOf(Team::class, $this->matchup->winningTeam);
        $this->assertEquals($this->teams[0]->id, $this->matchup->winner);
    }

    #[Test]
    public function a_matchup_has_many_picks()
    {
        $teams = Team::factory()->count(2)->create();
        $contest = Contest::factory()->create();
        $matchup = Matchup::factory()->create([
            'contest_id' => $contest->id,
            'team_1' => $teams[0]->id,
            'team_2' => $teams[1]->id
        ]);

        // Create picks with different users
        for ($i = 0; $i < 3; $i++) {
            Pick::factory()->create([
                'user_id' => User::factory()->create()->id, // New user for each pick
                'contest_id' => $contest->id,
                'matchup_id' => $matchup->id,
                'team_id' => $teams[0]->id // Using a team that's part of the matchup
            ]);
        }

        $this->assertCount(3, $matchup->picks);
        $this->assertInstanceOf(Pick::class, $matchup->picks->first());
    }

    #[Test]
    public function it_can_scope_active_matchups()
    {
        Matchup::query()->delete();
        
        Matchup::factory()->count(3)->create(['active' => true]);
        Matchup::factory()->count(2)->create(['active' => false]);

        $this->assertCount(3, Matchup::active()->get());
    }
}
