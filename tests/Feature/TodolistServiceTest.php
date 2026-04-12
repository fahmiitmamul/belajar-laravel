<?php

use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

beforeEach(function () {
    $this->todolistService = app(TodolistService::class);
});

test('todolist service not null', function () {
    expect($this->todolistService)->not->toBeNull();
});

test('save todo', function () {
    $this->todolistService->saveTodo("1", "Eko");

    $todolist = Session::get("todolist");

    foreach ($todolist as $value) {
        expect($value['id'])->toBe("1");
        expect($value['todo'])->toBe("Eko");
    }
});

test('get todolist empty', function () {
    expect($this->todolistService->getTodolist())->toBe([]);
});

test('get todolist not empty', function () {
    $expected = [
        [
            "id" => "1",
            "todo" => "Eko"
        ],
        [
            "id" => "2",
            "todo" => "Kurniawan"
        ]
    ];

    $this->todolistService->saveTodo("1", "Eko");
    $this->todolistService->saveTodo("2", "Kurniawan");

    expect($this->todolistService->getTodolist())->toBe($expected);
});

test('remove todo', function () {
    $this->todolistService->saveTodo("1", "Eko");
    $this->todolistService->saveTodo("2", "Kurniawan");

    expect(count($this->todolistService->getTodolist()))->toBe(2);

    $this->todolistService->removeTodo("3");
    expect(count($this->todolistService->getTodolist()))->toBe(2);

    $this->todolistService->removeTodo("1");
    expect(count($this->todolistService->getTodolist()))->toBe(1);

    $this->todolistService->removeTodo("2");
    expect(count($this->todolistService->getTodolist()))->toBe(0);
});