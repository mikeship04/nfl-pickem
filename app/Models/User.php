<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function contests()
    {
        return $this->hasMany(Contest::class, 'created_by');
    }

    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    public function participatingContests()
    {
        return $this->belongsToMany(Contest::class, 'picks')
            ->distinct();
    }
}
