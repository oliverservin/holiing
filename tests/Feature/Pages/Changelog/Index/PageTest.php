<?php

test('index screen can be rendered', function () {
    $response = $this->get('/changelog');

    $response->assertStatus(200);
});
