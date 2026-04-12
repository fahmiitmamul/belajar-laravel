<?php

test('Test Input', function () {
    $this->get('/input/hello?name=Eko')
    ->assertSeeText('Hello Eko');

    $this->post('/input/hello', [
        'name' => 'Eko'
    ])
    ->assertSeeText('Hello Eko');
});

test('Test Input Nested', function () {
    $this->post('/input/hello/first', [
            "name" => [
                "first" => "Eko",
                "last" => "Khannedy"
            ]
    ])
    ->assertSeeText("Hello Eko");
});

test('Test Input All', function () {
    $this->post('/input/hello/input', [
            "name" => [
                "first" => "Eko",
                "last" => "Khannedy"
            ]
    ])
    ->assertSeeText("name")->assertSeeText("first")
    ->assertSeeText("last")->assertSeeText("Eko")
    ->assertSeeText("Khannedy");
});

test('Test Input Array', function () {
    $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Apple Mac Book Pro",
                    "price" => 30000000
                ],
                [
                    "name" => "Samsung Galaxy S10",
                    "price" => 15000000
                ]
            ]
        ])
    ->assertSeeText("Apple Mac Book Pro")
    ->assertSeeText("Samsung Galaxy S10");
});

test('Tes Input Type', function () {
    $this->post('/input/type', [
            'name' => 'Budi',
            'married' => 'true',
            'birth_date' => '1990-10-10'
        ])
    ->assertSeeText('Budi')
    ->assertSeeText("true")
    ->assertSeeText("1990-10-10");
}); 

test('Test Filter Only', function () {
    $this->post('/input/filter/only', [
            "name" => [
                "first" => "Eko",
                "middle" => "Kurniawan",
                "last" => "Khannedy"
            ]
    ])
    ->assertSeeText("Eko")->assertSeeText("Khannedy")
    ->assertDontSeeText("Kurniawan");
});

test('Test Filter Except', function () {
    $this->post('/input/filter/except', [
            "username" => "khannedy",
            "password" => "rahasia",
            "admin" => "true"
    ])
    ->assertSeeText("khannedy")
    ->assertSeeText("rahasia")
    ->assertDontSeeText("admin");
});

test('Test Filter Merge', function () {
    $this->post('/input/filter/merge', [
            "username" => "khannedy",
            "password" => "rahasia",
            "admin" => "true"
        ])
    ->assertSeeText("khannedy")
    ->assertSeeText("rahasia")
    ->assertSeeText("admin")
    ->assertSeeText("false");
});