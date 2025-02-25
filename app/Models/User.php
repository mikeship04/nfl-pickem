<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    public function contests(): BelongsToMany
    {
        return $this->belongsToMany(Contest::class);
    }

    public function picks(): HasMany
    {
        return $this->hasMany(Pick::class);
    }
}
