<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'active',
        'created_by'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    const TYPES = [
        'season-long',
        'weekly',
        'survivor'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function matchups(): HasMany
    {
        return $this->hasMany(Matchup::class);
    }

    public function picks(): HasMany
    {
        return $this->hasMany(Pick::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}

