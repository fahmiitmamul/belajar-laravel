<?php

test('Test Todolist Access', function () {
    $this->withSession([
            "user" => "khannedy",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Eko"
                ],
                [
                    "id" => "2",
                    "todo" => "Kurniawan"
                ]
            ]
        ])
    ->get('/todolist')
    ->assertSeeText("1")
    ->assertSeeText("Eko")
    ->assertSeeText("2")
    ->assertSeeText("Kurniawan");
});

test("Test Add Todo Failed", function(){
    $this->withSession([
            "user" => "khannedy"
    ])->post("/todolist", [])
    ->assertSeeText("Todo is required");
});

test('Test Add Todo Success', function(){
     $this->withSession([
            "user" => "khannedy"
    ])->post("/todolist", [
        "todo" => "Eko"
    ])->assertRedirect("/todolist");
});

test('Test Remove Todolist', function(){
    $this->withSession([
            "user" => "khannedy",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Eko"
                ],
                [
                    "id" => "2",
                    "todo" => "Kurniawan"
                ]
            ]
        ])
    ->post("/todolist/1/delete")
    ->assertRedirect("/todolist");
});