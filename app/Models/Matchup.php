<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matchup extends Model
{
    use HasFactory;

    protected $fillable = ['contest_id', 'week', 'team_1', 'team_2', 'winner', 'active'];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}
