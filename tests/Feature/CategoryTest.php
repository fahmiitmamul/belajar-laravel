<?php

use App\Models\Category;

test('example', function () {
    $category = new Category;
    $category->id = 'GADGET';
    $category->name = 'Gadget';
    $category->description = 'Gadget';
    $result = $category->save();

    self::assertTrue($result);
});
