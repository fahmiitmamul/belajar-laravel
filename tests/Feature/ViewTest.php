<?php

test('Test View', function () {
    $this->get('/hello')
    ->assertSeeText('Hello Eko');

    $this->get('/hello-again')
    ->assertSeeText('Hello Eko');
});

test('Test Nested', function () {
    $this->get('/hello-world')
    ->assertSeeText('Hello Eko');
});

test('Test Template', function () {
    $this->view('hello', ['name' => 'Eko'])
    ->assertSeeText('Hello Eko');

    $this->view('hello.world', ['name' => 'Eko'])
    ->assertSeeText('Hello Eko');
});