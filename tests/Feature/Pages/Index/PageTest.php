<?php

test('index is redirected to dashboard', function () {
    $response = $this->get('/');

    $response->assertRedirect('/dashboard');
});
