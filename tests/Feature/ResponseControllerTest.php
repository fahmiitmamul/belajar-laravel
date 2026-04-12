<?php

test('Test Response', function () {
    $this->get('/response/hello')
    ->assertStatus(200)
    ->assertSeeText('hello response');
});


test('Test Header', function () {
    $this->get('/response/header')
    ->assertStatus(200)
    ->assertSeeText('Eko')->assertSeeText('Khannedy')
    ->assertHeader('Content-Type', 'application/json')
    ->assertHeader('Author', 'Programmer Zaman Now')
    ->assertHeader('App', 'Belajar Laravel');
});

test('Test View', function(){
     $this->get('/response/type/view')
    ->assertSeeText("Hello Eko");
});

test('Test Json', function(){
     $this->get('/response/type/json')
    ->assertJson([
        'firstName' => 'Eko',
        'lastName' => 'Khannedy'
    ]);
});

test('Test File', function(){
    $this->get('/response/type/file')
    ->assertHeader('Content-Type', "image/png");
});

test('Test Download', function(){
     $this->get('/response/type/download')
    ->assertDownload('Batu.png');
});