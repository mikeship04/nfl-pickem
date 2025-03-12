<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pick extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contest_id',
        'matchup_id',
        'team_id'
    ];

    protected static function booted()
    {
        static::creating(function ($pick) {
            $matchup = $pick->matchup;
            if (!in_array($pick->team_id, [$matchup->team_1, $matchup->team_2])) {
                throw new \InvalidArgumentException('Selected team must be part of the matchup');
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function matchup(): BelongsTo
    {
        return $this->belongsTo(Matchup::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

