<?php

use App\Models\Category;

test('Test Insert', function () {
    $category = new Category;
    $category->id = 'GADGET';
    $category->name = 'Gadget';
    $category->description = 'Gadget';
    $result = $category->save();

    self::assertTrue($result);
});

test('Test Insert Many', function () {
    $category = [];
    for ($i = 0; $i < 10; $i++) {
        $category[] = [
            'id' => 'GADGET'.$i,
            'name' => 'Gadget'.$i,
            'description' => 'Gadget'.$i,
        ];
    }

    $result = Category::insert($category);
    self::assertTrue($result);

    $total = Category::count();

    self::assertEquals(10, $total);
});

test('Test Find', function () {
    $this->seed(CategorySeeder::class);

    $category = Category::find('FOOD');

    self::assertNotNull($category);
    self::assertEquals('FOOD', $category->id);
    self::assertEquals('Food', $category->name);
    self::assertEquals('Food Category', $category->description);
});

test('Test Update', function () {
    $this->seed(CategorySeeder::class);

    $category = Category::query()->find('FOOD');
    $category->name = 'Food Updated';
    $category->description = 'Food Category Updated';
    $result = $category->save();

    self::assertTrue($result);
});
