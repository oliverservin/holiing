<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashid',
        'url',
        'clicks',
        'team_id',
        'comments',
        'domain_id',
        'last_clicked_at',
        'archived_at',
        'expires_at',
        'password',
    ];

    protected $casts = [
        'clicks' => 'integer',
        'last_clicked_at' => 'datetime',
        'archived_at' => 'datetime',
        'expires_at' => 'datetime',
        'password' => 'hashed',
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

    public function hasExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function hasPassword()
    {
        return (bool) $this->password;
    }

    public function hasBeenArchived()
    {
        return (bool) $this->archived_at;
    }

    public function archive()
    {
        $this->archived_at = now();

        $this->save();
    }
}
