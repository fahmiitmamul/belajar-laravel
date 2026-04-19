<?php

use Illuminate\Support\Facades\Validator;

test('TestValidator', function () {
    $data = [
        'username' => 'admin',
        'password' => '12345',
    ];

    $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    $validator = Validator::make($data, $rules);
    self::assertNotNull($validator);

    self::assertTrue($validator->passes());
    self::assertFalse($validator->fails());
});

test('TestValidatorInvalid', function () {
    $data = [
        'username' => '',
        'password' => '',
    ];

    $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    $validator = Validator::make($data, $rules);
    self::assertNotNull($validator);

    self::assertFalse($validator->passes());
    self::assertTrue($validator->fails());
});
