<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matchup extends Model
{
    use HasFactory;

    protected $fillable = [
        'contest_id',
        'team_1',
        'team_2',
        'week',
        'winner',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function teamOne()
    {
        return $this->belongsTo(Team::class, 'team_1');
    }

    public function teamTwo()
    {
        return $this->belongsTo(Team::class, 'team_2');
    }

    public function winningTeam()
    {
        return $this->belongsTo(Team::class, 'winner');
    }

    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
