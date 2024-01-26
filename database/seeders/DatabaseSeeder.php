<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ClickEvent;
use App\Models\User;
use App\Models\Domain;
use App\Models\ShortLink;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->withPersonalTeam()->create([
            'name' => 'Oliver',
            'email' => 'oliver@radiocubito.com',
        ]);

        Domain::factory()->create(['name' => 'holi.ing.test', 'team_id' => 1, 'public_domain' => true]);
        Domain::factory()->create(['name' => 'oliver.mx', 'team_id' => 1, 'public_domain' => false]);

        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://yclas.com']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://radiocubito.com']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);

        ClickEvent::factory()->count(902)->create(['domain_id' => '1', 'short_link_id' => '1']);
        ClickEvent::factory()->count(760)->create(['domain_id' => '1', 'short_link_id' => '2']);
        ClickEvent::factory()->count(543)->create(['domain_id' => '1', 'short_link_id' => '3']);
        ClickEvent::factory()->count(632)->create(['domain_id' => '1', 'short_link_id' => '4']);

        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
        ShortLink::factory()->create(['team_id' => 1, 'domain_id' => 1, 'url' => 'https://oliver.mx']);
    }
}
