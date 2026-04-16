<?php

use Database\Seeders\CategorySeeder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    DB::delete('delete from products');
    DB::delete('delete from categories');
    DB::delete('delete from counters');
});

function insertCategories()
{
    test()->seed(CategorySeeder::class);
}

function insertProducts()
{
    insertCategories();

    DB::table('products')->insert([
        'id' => '1',
        'name' => 'iPhone 14 Pro Max',
        'category_id' => 'SMARTPHONE',
        'price' => 20000000,
    ]);

    DB::table('products')->insert([
        'id' => '2',
        'name' => 'Samsung Galaxy S21 Ultra',
        'category_id' => 'SMARTPHONE',
        'price' => 18000000,
    ]);
}

function insertProductFood()
{
    DB::table('products')->insert([
        'id' => '3',
        'name' => 'Bakso',
        'category_id' => 'FOOD',
        'price' => 20000,
    ]);

    DB::table('products')->insert([
        'id' => '4',
        'name' => 'Mie Ayam',
        'category_id' => 'FOOD',
        'price' => 20000,
    ]);
}

function insertManyCategories()
{
    for ($i = 0; $i < 100; $i++) {
        DB::table('categories')->insert([
            'id' => "CATEGORY-$i",
            'name' => "Category $i",
            'created_at' => '2020-10-10 10:10:10',
        ]);
    }
}

test('insert', function () {
    DB::table('categories')->insert([
        'id' => 'GADGET',
        'name' => 'Gadget',
    ]);

    DB::table('categories')->insert([
        'id' => 'FOOD',
        'name' => 'Food',
    ]);

    $result = DB::select('select count(id) as total from categories');

    expect($result[0]->total)->toBe(2);
});

test('select', function () {
    DB::table('categories')->insert([
        ['id' => 'GADGET', 'name' => 'Gadget'],
        ['id' => 'FOOD', 'name' => 'Food'],
    ]);

    $collection = DB::table('categories')->select(['id', 'name'])->get();

    expect($collection)->not->toBeNull();

    $collection->each(fn ($item) => Log::info(json_encode($item)));
});

test('where', function () {
    insertCategories();

    $collection = DB::table('categories')
        ->where(function (Builder $builder) {
            $builder->where('id', 'SMARTPHONE')
                ->orWhere('id', 'LAPTOP');
        })->get();

    expect($collection)->toHaveCount(2);
});

test('where between', function () {
    insertCategories();

    $collection = DB::table('categories')
        ->whereBetween('created_at', ['2020-09-10 10:10:10', '2020-11-10 10:10:10'])
        ->get();

    expect($collection)->toHaveCount(4);
});

test('update', function () {
    insertCategories();

    DB::table('categories')
        ->where('id', 'SMARTPHONE')
        ->update(['name' => 'Handphone']);

    $collection = DB::table('categories')
        ->where('name', 'Handphone')
        ->get();

    expect($collection)->toHaveCount(1);
});

test('delete', function () {
    insertCategories();

    DB::table('categories')
        ->where('id', 'SMARTPHONE')
        ->delete();

    $collection = DB::table('categories')
        ->where('id', 'SMARTPHONE')
        ->get();

    expect($collection)->toHaveCount(0);
});

test('join', function () {
    insertProducts();

    $collection = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id', 'products.name', 'products.price', 'categories.name as category_name')
        ->get();

    expect($collection)->toHaveCount(2);
});

test('ordering', function () {
    insertProducts();

    $collection = DB::table('products')
        ->orderBy('price', 'desc')
        ->orderBy('name', 'asc')
        ->get();

    expect($collection)->toHaveCount(2);
});

test('aggregate', function () {
    insertProducts();

    expect(DB::table('products')->count())->toBe(2);
    expect(DB::table('products')->min('price'))->toBe(18000000);
    expect(DB::table('products')->max('price'))->toBe(20000000);
    expect(DB::table('products')->avg('price'))->toEqual(19000000);
    expect(DB::table('products')->sum('price'))->toEqual(38000000);
});

test('group by', function () {
    insertProducts();
    insertProductFood();

    $collection = DB::table('products')
        ->select('category_id', DB::raw('count(*) as total_product'))
        ->groupBy('category_id')
        ->orderBy('category_id', 'desc')
        ->get();

    expect($collection)->toHaveCount(2)
        ->and($collection[0]->category_id)->toBe('SMARTPHONE')
        ->and($collection[1]->category_id)->toBe('FOOD');
});

test('pagination', function () {
    insertCategories();

    $paginate = DB::table('categories')->paginate(2, ['*'], 'page', 2);

    expect($paginate->currentPage())->toBe(2)
        ->and($paginate->perPage())->toBe(2)
        ->and($paginate->lastPage())->toBe(2)
        ->and($paginate->total())->toBe(4);
});
