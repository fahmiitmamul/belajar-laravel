<?php

use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::delete('delete from categories');
});

test('Test Insert', function () {
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


test('Test Select', function () {
    $this->testInsert();

    $collection = DB::table("categories")->select(["id", "name"])->get();
    self::assertNotNull($collection);

    $collection->each(function ($item){
        Log::info(json_encode($item));
    });
});
