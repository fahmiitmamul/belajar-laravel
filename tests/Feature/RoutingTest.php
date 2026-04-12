<?php

test('Test Get', function () {
    $this->get('/pzn')
    ->assertStatus(200)
    ->assertSeeText('Hello Programmer Zaman Now');
});

test('Test Redirect', function () {
    $this->get('/youtube')
    ->assertRedirect('/pzn');
});

test('Test Fallback', function () {
    $this->get('/tidakada')
    ->assertSeeText('404 by Programmer Zaman Now');

    $this->get('/tidakadalagi')
    ->assertSeeText('404 by Programmer Zaman Now');

    $this->get('/ups')
    ->assertSeeText('404 by Programmer Zaman Now');
});

test('Test Route Parameter', function () {
    $this->get('/products/1')
    ->assertSeeText('Product 1');

    $this->get('/products/2')
    ->assertSeeText('Product 2');

    $this->get('/products/1/items/XXX')
    ->assertSeeText("Product 1, Item XXX");

    $this->get('/products/2/items/YYY')
    ->assertSeeText("Product 2, Item YYY");
});

test('Test Route Parameter Regex', function () {
    $this->get('/categories/100')
    ->assertSeeText('Category 100');

    $this->get('/categories/eko')
    ->assertSeeText('404 by Programmer Zaman Now');
});

test('Test Route Parameter Optional', function () {
    $this->get('/users/khannedy')
    ->assertSeeText('User khannedy');

    $this->get('/users/')
    ->assertSeeText('User 404');
});

test('Test Route Conflict', function () {
    $this->get('/conflict/budi')
    ->assertSeeText("Conflict budi");

    $this->get('/conflict/eko')
    ->assertSeeText("Conflict Eko Kurniawan Khannedy");
});

test('Test Named Route', function () {
    $this->get('/produk/12345')
    ->assertSeeText('Link http://localhost:8000/products/12345');

    $this->get('/produk-redirect/12345')
    ->assertRedirect('/products/12345');
});