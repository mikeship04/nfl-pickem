<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pick;
use App\Models\User;
use App\Models\Contest;
use App\Models\Matchup;
use App\Models\Team;
use PHPUnit\Framework\Attributes\Test;

class PickTest extends TestCase
{
    use RefreshDatabase;

    private $pick;
    private $user;
    private $contest;
    private $matchup;
    private $teams;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->teams = Team::factory()->count(2)->create();
        $this->contest = Contest::factory()->create();
        $this->matchup = Matchup::factory()->create([
            'contest_id' => $this->contest->id,
            'team_1' => $this->teams[0]->id,
            'team_2' => $this->teams[1]->id
        ]);
        $this->pick = Pick::factory()->create([
            'user_id' => $this->user->id,
            'contest_id' => $this->contest->id,
            'matchup_id' => $this->matchup->id,
            'team_id' => $this->teams[0]->id
        ]);
    }

    #[Test]
    public function a_pick_can_be_created()
    {
        $this->assertDatabaseHas('picks', ['id' => $this->pick->id]);
    }

    #[Test]
    public function a_pick_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->pick->user);
        $this->assertEquals($this->user->id, $this->pick->user_id);
    }

    #[Test]
    public function a_pick_belongs_to_a_contest()
    {
        $this->assertInstanceOf(Contest::class, $this->pick->contest);
        $this->assertEquals($this->contest->id, $this->pick->contest_id);
    }

    #[Test]
    public function a_pick_belongs_to_a_matchup()
    {
        $this->assertInstanceOf(Matchup::class, $this->pick->matchup);
        $this->assertEquals($this->matchup->id, $this->pick->matchup_id);
    }

    #[Test]
    public function a_pick_belongs_to_a_team()
    {
        $this->assertInstanceOf(Team::class, $this->pick->team);
        $this->assertEquals($this->teams[0]->id, $this->pick->team_id);
    }

    #[Test]
    public function user_cannot_have_duplicate_picks_in_same_contest()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Pick::factory()->create([
            'user_id' => $this->user->id,
            'contest_id' => $this->contest->id,
            'matchup_id' => $this->matchup->id,
            'team_id' => $this->teams[1]->id
        ]);
    }

    #[Test]
    public function pick_team_must_be_part_of_matchup()
    {
        $otherTeam = Team::factory()->create();
        
        $this->expectException(\InvalidArgumentException::class);
        
        Pick::factory()->create([
            'user_id' => $this->user->id,
            'contest_id' => $this->contest->id,
            'matchup_id' => $this->matchup->id,
            'team_id' => $otherTeam->id
        ]);
    }
}
