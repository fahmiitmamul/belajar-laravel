<?php

use App\Services\UserService;

beforeEach(function () {
    $this->userService = app(UserService::class);
});

test('login success', function () {
    expect($this->userService->login("khannedy", "rahasia"))->toBeTrue();
});

test('login user not found', function () {
    expect($this->userService->login("eko", "eko"))->toBeFalse();
});

test('login wrong password', function () {
    expect($this->userService->login("khannedy", "salah"))->toBeFalse();
});