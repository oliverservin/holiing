<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Livewire\Volt\Volt;

test('create link page can be rendered', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $this->actingAs($user);

    $response = $this->get('/short-links/create');

    $response->assertStatus(200);
});

test('guests cannot access create link page', function () {
    $response = $this->get('/short-links/create');

    $response
        ->assertStatus(302)
        ->assertRedirect('/login');
});

test('url metadata can be obtained', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <title>Example Domain</title>
            <meta name="description" content="This domain is for use in illustrative examples in documents.">
            <meta property="og:image" content="https://example.com/image.png">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component
        ->assertSet('socialPreview.title', 'Example Domain')
        ->assertSet('socialPreview.description', 'This domain is for use in illustrative examples in documents.')
        ->assertSet('socialPreview.image', 'https://example.com/image.png')
        ->assertSet('socialPreview.domain', 'example.com');
});

test('url title metadata can be obtained from og:title', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <title>Not the OG Title</title>
            <meta property="og:title" content="OG Title Example">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component->assertSet('socialPreview.title', 'OG Title Example');
});

test('url title metadata can be obtained from twitter:title', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <title>Not the Twitter Title</title>
            <meta property="twitter:title" content="Twitter Title Example">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component->assertSet('socialPreview.title', 'Twitter Title Example');
});

test('url description metadata can be obtained from meta description tag', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <meta name="description" content="Example Meta Description">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component->assertSet('socialPreview.description', 'Example Meta Description');
});

test('url description metadata can be obtained from twitter:description', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <meta property="twitter:description" content="Twitter Description Example">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component->assertSet('socialPreview.description', 'Twitter Description Example');
});

test('url description metadata can be obtained from og:description', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <meta property="og:description" content="Open Graph Description Example">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component->assertSet('socialPreview.description', 'Open Graph Description Example');
});

test('url image metadata can be obtained from og:image', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <meta property="og:image" content="https://example.com/image.jpg">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component->assertSet('socialPreview.image', 'https://example.com/image.jpg');
});

test('url image metadata can be obtained from twitter:image', function () {
    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    Http::fake(['https://example.com' => Http::response('
        <html>
        <head>
            <meta property="twitter:image" content="https://example.com/twitter-image.jpg">
        </head>
        <body></body>
        </html>
    ', 200)]);

    $component = Volt::test('short-links.create')
        ->set('url', 'https://example.com');

    $component->assertSet('socialPreview.image', 'https://example.com/twitter-image.jpg');
});
