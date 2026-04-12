<?php

test('Test Guest Access', function () {
    $this->get('/')
    ->assertRedirect("/login");
});

test('Test Member Access', function () {
    $this->withSession([
            "user" => "khannedy"
    ])->get('/')
    ->assertRedirect("/todolist");
});