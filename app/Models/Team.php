<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $casts = [
        'personal_team' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'personal_team',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function links()
    {
        return $this->hasMany(ShortLink::class);
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
