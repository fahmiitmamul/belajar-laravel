<?php

use Illuminate\Support\Facades\Config;

test('Test Config', function () {
    $firstName1 = config('contoh.author.first');
    $firstName2 = config('contoh.author.first');

    self::assertEquals($firstName1, $firstName2);

    var_dump(Config::all());
});

test('Test Config Dependency', function () {
    $config = $this->app->make('config');
    $firstName3 = $config->get('contoh.author.first');
    
    $firstName1 = config('contoh.author.first');
    $firstName2 = Config::get('contoh.author.first');

    self::assertEquals($firstName1, $firstName2);
    self::assertEquals($firstName1, $firstName3);

    var_dump($config->all());
});

test('Test Facade Mock', function () {
    Config::shouldReceive('get')
        ->with('contoh.author.first')
        ->andReturn('Eko Keren');

    $firstName = Config::get('contoh.author.first');
    self::assertEquals('Eko Keren', $firstName);
});