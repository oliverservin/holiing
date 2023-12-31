<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->withPersonalTeam()->create([
            'name' => 'Oliver',
            'email' => 'oliver@radiocubito.com',
        ]);

        Domain::factory()->create([
            'name' => 'holi.ing.test',
            'team_id' => $user->currentTeam,
            'public_domain' => true,
        ]);

        Domain::factory()->create([
            'name' => 'oliver.mx',
            'team_id' => $user->currentTeam,
            'public_domain' => false,
        ]);
    }
}
