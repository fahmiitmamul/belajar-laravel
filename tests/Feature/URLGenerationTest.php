<?php

test('Test URL Current', function () {
    $this->get('/url/current?name=Eko')
    ->assertSeeText("/url/current?name=Eko");
});

test('Test Named', function () {
    $this->get('/redirect/named')
    ->assertSeeText("/redirect/name/Eko");
});

test('Test Action', function () {
    $this->get('/url/action')
    ->assertSeeText("/form");
});