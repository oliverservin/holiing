<?php

test('index screen can be rendered', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
