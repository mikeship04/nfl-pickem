<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Contest;
use App\Models\Pick;
use App\Models\Matchup;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function a_user_can_be_created()
    {
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => $this->user->email
        ]);
    }

    #[Test]
    public function user_has_many_created_contests()
    {
        Contest::factory()->count(3)->create([
            'created_by' => $this->user->id
        ]);

        $this->assertCount(3, $this->user->contests);
        $this->assertInstanceOf(Contest::class, $this->user->contests->first());
    }

    #[Test]
    public function user_has_many_picks()
    {
        // Create teams first
        $teams = Team::factory()->count(2)->create();
        $contest = Contest::factory()->create();
        
        // Create three different matchups
        $matchups = collect(range(1, 3))->map(function () use ($contest, $teams) {
            return Matchup::factory()->create([
                'contest_id' => $contest->id,
                'team_1' => $teams[0]->id,
                'team_2' => $teams[1]->id
            ]);
        });
        
        // Create a pick for each matchup
        foreach ($matchups as $matchup) {
            Pick::factory()->create([
                'user_id' => $this->user->id,
                'contest_id' => $contest->id,
                'matchup_id' => $matchup->id,
                'team_id' => $teams[0]->id
            ]);
        }

        $this->assertCount(3, $this->user->picks);
        $this->assertInstanceOf(Pick::class, $this->user->picks->first());
    }

    #[Test]
    public function user_password_is_hashed()
    {
        $user = User::factory()->create([
            'password' => 'password123'
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test]
    public function user_email_must_be_unique()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create([
            'email' => $this->user->email
        ]);
    }

    #[Test]
    public function user_can_participate_in_many_contests()
    {
        $teams = Team::factory()->count(2)->create();
        $contests = Contest::factory()->count(3)->create();
        
        foreach ($contests as $contest) {
            $matchup = Matchup::factory()->create([
                'contest_id' => $contest->id,
                'team_1' => $teams[0]->id,
                'team_2' => $teams[1]->id
            ]);
            
            Pick::factory()->create([
                'user_id' => $this->user->id,
                'contest_id' => $contest->id,
                'matchup_id' => $matchup->id,
                'team_id' => $teams[0]->id  // Use one of the teams from the matchup
            ]);
        }

        $this->assertCount(3, $this->user->participatingContests);
    }
}
