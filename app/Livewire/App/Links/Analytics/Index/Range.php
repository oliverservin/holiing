<?php

namespace App\Livewire\App\Links\Analytics\Index;

use Illuminate\Support\Carbon;

enum Range: string
{
    case Last_90 = 'last90';
    case Last_30 = 'last30';
    case Last_14 = 'last14';
    case Last_7 = 'last7';

    public function label($start = null, $end = null)
    {
        return match ($this) {
            static::Last_90 => '90d',
            static::Last_30 => '30d',
            static::Last_14 => '14d',
            static::Last_7 => '7d',
        };
    }

    public function dates()
    {
        return match ($this) {
            static::Last_7 => [Carbon::today()->subDays(6), now()],
            static::Last_14 => [Carbon::today()->subDays(13), now()],
            static::Last_30 => [Carbon::today()->subDays(29), now()],
            static::Last_90 => [Carbon::today()->subDays(59), now()],
        };
    }
}
