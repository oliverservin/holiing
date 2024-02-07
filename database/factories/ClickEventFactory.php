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
            'device' => 'Macintosh',
            'browser' => 'Safari',
            'browser_version' => '17.3',
            'platform' => 'OS X',
            'platform_version' => '10_5_7',
            'bot' => 0,
            'ua' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3 Safari/605.1.15',
            'referer' => '(direct)',
            'referer_url' => '(direct)',
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
