<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClickEvent>
 */
class ClickEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'domain_id' => Domain::factory(),
            'short_link_id' => ShortLink::factory(),
            'country' => fake()->countryCode(),
            'device' => fake()->randomElement(['desktop', 'mobile', 'tablet', 'unknown']),
            'browser' => 'Safari',
            'browser' => fake()->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera', 'Internet Explorer']),
            'bot' => 0,
            'referer' => '(direct)',
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
