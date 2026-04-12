<?php

test('Test Create Session', function () {
    $this->get('/session/create')
    ->assertSeeText("OK")
    ->assertSessionHas("userId", "khannedy")
    ->assertSessionHas("isMember", true);
});

test('Test Get Session', function () {
    $this->withSession([
            "userId" => "khannedy",
            "isMember" => "true"
    ])
    ->get('/session/get')
    ->assertSeeText("User Id : khannedy, Is Member : true");
});

test('Test Get Session Failed', function () {
     $this->withSession([])
     ->get('/session/get')
    ->assertSeeText("User Id : guest, Is Member : false");
});