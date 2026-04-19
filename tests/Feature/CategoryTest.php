<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses()->group('category');

uses(RefreshDatabase::class);

test('insert', function () {
    $category = new Category;
    $category->id = 'GADGET';
    $category->name = 'Gadget';
    $category->description = 'Gadget';

    expect($category->save())->toBeTrue();
});

test('insert_many', function () {
    $categories = [];

    for ($i = 0; $i < 10; $i++) {
        $categories[] = [
            'id' => "ID $i",
            'name' => "Name $i",
            'is_active' => true,
            'description' => "Description $i",
        ];
    }

    expect(Category::insert($categories))->toBeTrue();
    expect(Category::count())->toBe(10);
});

test('find', function () {
    $this->seed(CategorySeeder::class);

    $category = Category::find('FOOD');

    expect($category)->not->toBeNull()
        ->and($category->id)->toBe('FOOD')
        ->and($category->name)->toBe('Food')
        ->and($category->description)->toBe('Food Category');
});

test('update', function () {
    $this->seed(CategorySeeder::class);

    $category = Category::find('FOOD');
    $category->name = 'Food Updated';

    expect($category->update())->toBeTrue();
});

test('select', function () {
    for ($i = 0; $i < 5; $i++) {
        Category::create([
            'id' => "ID $i",
            'name' => "Name $i",
            'description' => "Description $i",
            'is_active' => true,
        ]);
    }

    $categories = Category::whereNull('description')->get();

    expect($categories)->toHaveCount(0);

    $categories->each(function ($category) {
        expect($category->description)->toBeNull();

        $category->update([
            'description' => 'Updated',
        ]);
    });
});

test('update_many', function () {
    $categories = [];

    for ($i = 0; $i < 10; $i++) {
        $categories[] = [
            'id' => "ID $i",
            'name' => "Name $i",
            'description' => "Description $i",
            'is_active' => true,
        ];
    }

    Category::insert($categories);

    Category::whereNull('description')->update([
        'description' => 'Updated',
    ]);

    expect(Category::where('description', 'Updated')->count())->toBe(0);
});

test('delete', function () {
    $this->seed(CategorySeeder::class);

    $category = Category::find('FOOD');

    expect($category->delete())->toBeTrue();
    expect(Category::count())->toBe(0);
});

test('delete many', function () {
    $categories = [];

    for ($i = 0; $i < 10; $i++) {
        $categories[] = [
            'id' => "ID $i",
            'name' => "Name $i",
            'description' => "Description $i",
            'is_active' => true,
        ];
    }

    Category::insert($categories);

    expect(Category::count())->toBe(10);

    Category::whereNull('description')->delete();

    expect(Category::count())->toBe(10);
});

test('create', function () {
    $category = new Category([
        'id' => 'FOOD',
        'name' => 'Food',
        'description' => 'Food Category',
        'is_active' => true,
    ]);

    $category->save();

    expect($category->id)->not->toBeNull();
});

test('create_using_query_builder', function () {
    $category = Category::create([
        'id' => 'FOOD',
        'name' => 'Food',
        'description' => 'Food Category',
    ]);

    expect($category->id)->not->toBeNull();
});

test('update_mass', function () {
    $this->seed(CategorySeeder::class);

    $category = Category::find('FOOD');

    $category->fill([
        'name' => 'Food Updated',
        'description' => 'Food Category Updated',
    ])->save();

    expect($category->id)->not->toBeNull();
});

test('global_scope', function () {
    Category::create([
        'id' => 'FOOD',
        'name' => 'Food',
        'description' => 'Food Category',
        'is_active' => false,
    ]);

    // expect(Category::find('FOOD'))->toBeNull();

    $category = Category::withoutGlobalScopes([IsActiveScope::class])->find('FOOD');

    expect($category)->not->toBeNull();
});

test('one_to_many', function () {
    $this->seed([CategorySeeder::class, ProductSeeder::class]);

    $category = Category::find('FOOD');

    expect($category)->not->toBeNull()
        ->and($category->products)->toHaveCount(2);
});

test('one_to_many_query', function () {
    $category = Category::create([
        'id' => 'FOOD',
        'name' => 'Food',
        'description' => 'Food Category',
        'is_active' => true,
    ]);

    $product = new Product([
        'id' => '1',
        'name' => 'Product 1',
        'description' => 'Description 1',
    ]);

    $category->products()->save($product);

    expect($product->category_id)->not->toBeNull();
});

test('relationship_query', function () {
    $this->seed([CtegorySeeder::class, ProductSeeder::class]);

    $category = Category::find('FOOD');

    expect($category->products)->toHaveCount(2);

    $out = $category->products()->where('stock', '<=', 0)->get();

    expect($out)->toHaveCount(2);
});

test('has_many_through', function () {
    $this->seed([
        CategorySeeder::class,
        ProductSeeder::class,
        CustomerSeeder::class,
        ReviewSeeder::class,
    ]);

    $category = Category::find('FOOD');

    expect($category->reviews)->toHaveCount(2);
});

test('querying_relations', function () {
    $this->seed([CategorySeeder::class, ProductSeeder::class]);

    $category = Category::find('FOOD');

    $products = $category->products()->where('price', 200)->get();

    expect($products)->toHaveCount(1)
        ->and($products[0]->id)->toBe('2');
});

test('aggregating_relations', function () {
    $this->seed([CategorySeeder::class, ProductSeeder::class]);

    $category = Category::find('FOOD');

    expect($category->products()->count())->toBe(2);
    expect($category->products()->where('price', 200)->count())->toBe(1);
});
