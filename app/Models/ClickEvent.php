<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'short_link_id',
        'country',
        'device',
        'browser',
        'browser_version',
        'platform',
        'platform_version',
        'bot',
        'ua',
        'referer',
        'referer_url',
    ];

    protected $casts = [
        'bot' => 'boolean',
    ];
}
