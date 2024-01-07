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
        'clicks',
        'team_id',
        'domain_id',
        'last_clicked_at',
    ];

    protected $casts = [
        'clicks' => 'integer',
        'last_clicked_at' => 'datetime',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
