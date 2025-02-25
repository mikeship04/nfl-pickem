<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'active', 'created_by'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function matchups(): HasMany
    {
        return $this->hasMany(Matchup::class);
    }
}

