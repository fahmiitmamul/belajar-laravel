<?php

test('Test Create Cookie', function () {
    $this->get('/cookie/set')
    ->assertSeeText('Hello Cookie')
    ->assertCookie("User-Id", "khannedy")
    ->assertCookie("Is-Member", "true");
});

test('Test Get Cookie', function () {
    $this->withCookie("User-Id", "khannedy")
    ->withCookie("Is-Member", "true")
    ->get('/cookie/get')
    ->assertJson([
        "userId" => "khannedy",
        "isMember" => "true"
    ]);
});