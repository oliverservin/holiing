<?php

namespace App\Livewire\App\Links\Analytics\Index;

use Illuminate\Support\Carbon;

enum Range: string
{
    case Year = 'year';
    case Last_90 = 'last90';
    case Last_30 = 'last30';
    case Last_7 = 'last7';
    case Today = 'today';

    public function label($start = null, $end = null)
    {
        return match ($this) {
            static::Year => 'This Year',
            static::Last_90 => 'Last 90 Days',
            static::Last_30 => 'Last 30 Days',
            static::Last_7 => 'Last 7 Days',
            static::Today => 'Today',
        };
    }

    public function dates()
    {
        return match ($this) {
            static::Today => [Carbon::today(), now()],
            static::Last_7 => [Carbon::today()->subDays(6), now()],
            static::Last_30 => [Carbon::today()->subDays(29), now()],
            static::Last_90 => [Carbon::today()->subDays(59), now()],
            static::Year => [Carbon::now()->startOfYear(), now()],
        };
    }
}
