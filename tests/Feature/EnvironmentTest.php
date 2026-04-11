<?php

use Illuminate\Support\Env;

test('Test Get Env', function () {
    $youtube = env('YOUTUBE');
    $this->assertEquals('PZN', $youtube);
});

test('Test Get Env Default Value', function () {
    $author = Env::get('AUTHOR', 'Eko');
    $this->assertEquals('Eko', $author);
});
