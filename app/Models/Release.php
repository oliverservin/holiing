<?php

namespace App\Models;

use Sushi\Sushi;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Release extends Model
{
    use Sushi;

    protected $rows = [
        [
            'title' => '1.4',
            'date' => '2024-02-08',
        ],
        [
            'title' => '1.3',
            'date' => '2024-02-07',
        ],
        [
            'title' => '1.2.1',
            'date' => '2024-02-01',
        ],
        [
            'title' => '1.2.0',
            'date' => '2024-02-01',
        ],
        [
            'title' => '1.1.0',
            'date' => '2024-01-03',
        ],
        [
            'title' => '1.0.0',
            'date' => '2023-12-28',
        ],
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function dateForHumans()
    {
        return $this->date->translatedFormat(
            $this->date->year === now()->year
                ? 'M d'
                : 'M d, Y'
        );
    }

    public function description()
    {
        $filesystem = app(Filesystem::class);

        $content = $filesystem->get(resource_path("md/releases/{$this->title}.md"));

        return Str::of($content)->markdown();
    }
}
