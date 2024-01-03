<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $casts = [
        'public_domain' => 'boolean',
        'validated_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'public_domain',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function links()
    {
        return $this->hasMany(ShortLink::class);
    }
}
