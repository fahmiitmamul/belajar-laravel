<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    $message = $validator->getMessageBag();

    Log::info($message->toJson(JSON_PRETTY_PRINT));
});

test('TestValidatorException', function () {
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

    try {
        $validator->validate();
        self::fail('ValidationException not thrown');
    } catch (ValidationException $exception) {
        self::assertNotNull($exception->validator);
        $message = $exception->validator->errors();
        Log::error($message->toJson(JSON_PRETTY_PRINT));
    }
});
