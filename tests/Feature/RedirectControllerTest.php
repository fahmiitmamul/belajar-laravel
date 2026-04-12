<?php

test('Test Redirect', function () {
     $this->get('/redirect/from')
    ->assertRedirect('/redirect/to');
});

test('Test Redirect Name', function () {
    $this->get('/redirect/name')
    ->assertRedirect('/redirect/name/Eko');
});

test('Test Redirect Action', function () {
    $this->get('/redirect/action')
    ->assertRedirect('/redirect/name/Eko');
});

test('Test Redirect Away', function () {
    $this->get('/redirect/away')
    ->assertRedirect('https://www.programmerzamannow.com/');
});