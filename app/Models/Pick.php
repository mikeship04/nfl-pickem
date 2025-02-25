<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pick extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'matchup_id', 'team_id', 'points'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

