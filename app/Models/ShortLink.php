<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashid',
        'url',
        'visits',
        'team_id',
        'domain_id',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
