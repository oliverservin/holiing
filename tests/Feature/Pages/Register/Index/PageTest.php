<?php

use App\Providers\RouteServiceProvider;
use Livewire\Volt\Volt;

test('index screen can be rendered', function () {
    $response = $this->get('/register');

    $response
        ->assertOk()
        ->assertSeeVolt('pages.register');
});

test('new users can register', function () {
    $component = Volt::test('pages.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $component->call('register');

    $component->assertRedirect(RouteServiceProvider::HOME);

    $this->assertAuthenticated();
});
