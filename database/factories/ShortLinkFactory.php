<?php

namespace Database\Factories;

use App\HashIdGenerator;
use App\Models\Domain;
use App\Models\Team;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain>
 */
class ShortLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hashids = new Hashids();
        $hashIdGenerator = new HashIdGenerator($hashids);

        return [
            'team_id' => Team::factory(),
            'domain_id' => Domain::factory(),
            'url' => fake()->url(),
            'hashid' => $hashIdGenerator->generate(),
            'clicks' => fake()->randomNumber(3, strict: false),
            'last_clicked_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ];
    }
}
