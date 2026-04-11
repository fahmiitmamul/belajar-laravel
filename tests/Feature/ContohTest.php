<?php

test('Contoh Test', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
