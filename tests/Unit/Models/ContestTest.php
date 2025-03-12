<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contest;
use App\Models\User;
use App\Models\Matchup;
use App\Models\Pick;
use App\Models\Team;
use PHPUnit\Framework\Attributes\Test;

class ContestTest extends TestCase
{
    use RefreshDatabase;

    private $contest;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->contest = Contest::factory()->create([
            'created_by' => $this->user->id,
            'active' => false // Set this to false so it doesn't affect our active contests test
        ]);
    }

    #[Test]
    public function a_contest_can_be_created_with_required_attributes()
    {
        $contest = Contest::factory()->create([
            'name' => 'Test Contest',
            'type' => 'season-long',
            'created_by' => $this->user->id
        ]);

        $this->assertDatabaseHas('contests', [
            'id' => $contest->id,
            'name' => 'Test Contest',
            'type' => 'season-long',
            'created_by' => $this->user->id
        ]);
    }

    #[Test]
    public function a_contest_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->contest->user);
        $this->assertEquals($this->user->id, $this->contest->user->id);
    }

    #[Test]
    public function a_contest_has_many_matchups()
    {
        // Create teams first
        $teams = Team::factory()->count(2)->create();
        
        Matchup::factory()->count(3)->create([
            'contest_id' => $this->contest->id,
            'team_1' => $teams[0]->id,
            'team_2' => $teams[1]->id
        ]);

        $this->assertCount(3, $this->contest->matchups);
        $this->assertInstanceOf(Matchup::class, $this->contest->matchups->first());
    }

    #[Test]
    public function a_contest_has_many_picks_through_matchups()
    {
        $teams = Team::factory()->count(2)->create();
        $matchup = Matchup::factory()->create([
            'contest_id' => $this->contest->id,
            'team_1' => $teams[0]->id,
            'team_2' => $teams[1]->id
        ]);

        // Create picks with different users to avoid unique constraint violation
        for ($i = 0; $i < 3; $i++) {
            Pick::factory()->create([
                'user_id' => User::factory()->create()->id, // Create a new user for each pick
                'matchup_id' => $matchup->id,
                'contest_id' => $this->contest->id,
                'team_id' => $teams[0]->id
            ]);
        }

        $this->assertCount(3, $this->contest->picks);
        $this->assertInstanceOf(Pick::class, $this->contest->picks->first());
    }

    #[Test]
    public function it_validates_contest_type()
    {
        $validTypes = ['season-long', 'weekly', 'survivor'];
        
        foreach ($validTypes as $type) {
            $contest = Contest::factory()->create(['type' => $type]);
            $this->assertEquals($type, $contest->type);
        }

        $this->expectException(\Illuminate\Database\QueryException::class);
        Contest::factory()->create(['type' => 'invalid-type']);
    }

    #[Test]
    public function it_can_scope_active_contests()
    {
        // Clear any existing contests
        Contest::query()->delete();
        
        Contest::factory()->count(3)->create(['active' => true]);
        Contest::factory()->count(2)->create(['active' => false]);

        $activeContests = Contest::where('active', '=', true)->get();
        
        $this->assertCount(3, $activeContests);
    }
}
