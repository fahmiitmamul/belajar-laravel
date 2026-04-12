<?php

test('Test Login Page', function () {
    $this->get('/login')
    ->assertSeeText("Login");
});

test('Test Login Page For Member', function () {
    $this->withSession([
            "user" => "khannedy"
    ])
    ->get('/login')
    ->assertRedirect("/");
});

test('Test Login Success', function () {
    $this->post('/login', [
            "user" => "khannedy",
            "password" => "rahasia"
    ])
    ->assertRedirect("/")
    ->assertSessionHas("user", "khannedy");
});

test('Test Login For User Already Login', function () {
    $this->withSession([
            "user" => "khannedy"
    ])->post('/login', [
        "user" => "khannedy",
        "password" => "rahasia"
    ])->assertRedirect("/");
});          

test('Test Login Validation Error', function () {
    $this->post("/login", [])
    ->assertSeeText("User or password is required");
});

test("Test Login Failed", function(){
     $this->post('/login', [
            'user' => "wrong",
            "password" => "wrong"
    ])->assertSeeText("User or password is wrong");
});

test('Test Logout', function () {
    $this->withSession([
            "user" => "khannedy"
        ])
    ->post('/logout')
    ->assertRedirect("/")
    ->assertSessionMissing("user");
});

test('Test Logout For Guest', function () {
    $this->post('/logout')
    ->assertRedirect("/");
});