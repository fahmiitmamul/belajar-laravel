<?php

use App\Rules\Uppercase;
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

test('TestValidatorMultipleRules', function () {
    App::setLocale('id');

    $data = [
        'username' => 'eko',
        'password' => 'eko',
    ];

    $rules = [
        'username' => 'required|email|max:100',
        'password' => ['required', 'min:6', 'max:20'],
    ];

    $validator = Validator::make($data, $rules);
    self::assertNotNull($validator);

    self::assertFalse($validator->passes());
    self::assertTrue($validator->fails());
});

test('TestValidatorValidData', function () {
    $data = [
        'username' => 'admin@pzn.com',
        'password' => 'rahasia',
    ];

    $rules = [
        'username' => 'required|email|max:100',
        'password' => 'required|min:6|max:20',
    ];

    $validator = Validator::make($data, $rules);
    self::assertNotNull($validator);

    try {
        $valid = $validator->validate();
        Log::info(json_encode($valid, JSON_PRETTY_PRINT));
    } catch (ValidationException $exception) {
        self::assertNotNull($exception->validator);
        $message = $exception->validator->errors();
        Log::error($message->toJson(JSON_PRETTY_PRINT));
    }
});

test('TestValidatorInlineMessage', function () {
    $data = [
        'username' => 'eko',
        'password' => 'eko',
    ];

    $rules = [
        'username' => 'required|email|max:100',
        'password' => ['required', 'min:6', 'max:20'],
    ];

    $messages = [
        'required' => ':attribute harus diisi',
        'email' => ':attribute harus diisi',
        'min' => ':attribute harus diisi',
        'max' => ':attribute harus diisi',
    ];

    $validator = Validator::make($data, $rules, $messages);
    self::assertNotNull($validator);

    self::assertFalse($validator->passes());
    self::assertTrue($validator->fails());

    $message = $validator->getMessageBag();
    Log::info($message->toJson(JSON_PRETTY_PRINT));
});

test('TestValidatorCustomRules', function () {
    $data = [
        'username' => 'eko@pzn.com',
        'password' => 'eko@pzn.com',
    ];

    $rules = [
        'username' => ['required', 'email', 'max:100', new Uppercase],
        'password' => ['required', 'min:6', 'max:20'],
    ];

    $messages = [
        'required' => ':attribute harus diisi',
        'email' => ':attribute harus diisi',
        'min' => ':attribute harus diisi',
        'max' => ':attribute harus diisi',
    ];

    $validator = Validator::make($data, $rules, $messages);
    self::assertNotNull($validator);

    self::assertFalse($validator->passes());
    self::assertTrue($validator->fails());

    $message = $validator->getMessageBag();
    Log::info($message->toJson(JSON_PRETTY_PRINT));
});
