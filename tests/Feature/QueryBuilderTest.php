<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    DB::delete('delete from categories');
});

test('insert', function () {
    DB::table("categories")->insert([
        "id" => "GADGET",
        "name" => 'Gadget'
    ]);

    DB::table("categories")->insert([
        "id" => "FOOD",
        "name" => 'Food'
    ]);

    $result = DB::select("select count(id) as total from categories");

    self::assertEquals(2, $result[0]->total);
});

test('select', function () {
    DB::table("categories")->insert([
        ["id" => "GADGET", "name" => "Gadget"],
        ["id" => "FOOD", "name" => "Food"],
    ]);

    $collection = DB::table("categories")
        ->select(["id", "name"])
        ->get();

    expect($collection)->not->toBeNull();

    $collection->each(fn ($item) => Log::info(json_encode($item)));
});

test('where', function () {
    DB::table("categories")->insert([
        ["id" => "SMARTPHONE", "name" => "Smartphone"],
        ["id" => "LAPTOP", "name" => "Laptop"],
        ["id" => "FOOD", "name" => "Food"],
    ]);

    $collection = DB::table("categories")
        ->where(function ($builder) {
            $builder->where('id', '=', 'SMARTPHONE');
            $builder->orWhere('id', '=', 'LAPTOP');
        })
        ->get();

    self::assertCount(2, $collection);

    $collection->each(function ($item) {
        Log::info(json_encode($item));
    });
});

