<?php

namespace App\Models;

use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function clickEvents()
    {
        return $this->hasMany(ClickEvent::class);
    }

    public function dateForHumans()
    {
        return $this->created_at->format(
            $this->created_at->year === now()->year
                ? 'M d, g:i A'
                : 'M d, Y, g:i A'
        );
    }

    public function clicksForHumans()
    {
        return Number::format($this->clicks);
    }

    public function lastClickedForHumans()
    {
        if (! $this->last_clicked_at) {
            return '—';
        }

        return $this->last_clicked_at->format(
            $this->last_clicked_at->year === now()->year
                ? 'M d, g:i A'
                : 'M d, Y, g:i A'
        );
    }
}
