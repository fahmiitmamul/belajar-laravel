<?php

test('Test Middleware Invalid', function () {
    $this->get('/middleware/api')
    ->assertStatus(401)
    ->assertSeeText('Access Denied'); 
});


test('Test Middleware Valid', function () {
    $this->withHeader('X-API-KEY', 'PZN')
    ->get('/middleware/api')
    ->assertStatus(200)
    ->assertSeeText('OK');
});

test('Test Middleware Invalid Group', function () {
    $this->get('/middleware/group')
    ->assertStatus(401)
    ->assertSeeText('Access Denied'); 
});

test('Test Middleware Valid Group', function () {
    $this->withHeader('X-API-KEY', 'PZN')
    ->get('/middleware/group')
    ->assertStatus(200)
    ->assertSeeText('GROUP');
});