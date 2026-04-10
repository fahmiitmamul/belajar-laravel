<?php

use Illuminate\Support\LazyCollection;

test('Collection Test', function () {
    $collection = collect([1, 2, 3]);
    $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());
});

test('For Each Test', function () {
    $collection = collect([1, 2, 3]);
    foreach ($collection as $key => $value) {
        $this->assertEquals($key + 1, $value);
    }
}); 

test('CRUD Test', function () {
    $collection = collect([]);
    $collection->push(1, 2, 3);
    $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());

    $result = $collection->pop();
    $this->assertEquals(3, $result);
    $this->assertEqualsCanonicalizing([1, 2], $collection->all());
});

test('Map Test', function () {
    $collection = collect([1, 2, 3]);
    $result = $collection->map(function ($item) {
        return $item * 2;
    });
    $this->assertEqualsCanonicalizing([2, 4, 6], $result->all());
});

test('Test Map Into', function () {
    $collection = collect([1, 2, 3]);
    $result = $collection->map(function ($item) {
        return $item * 2;
    });
    $this->assertEqualsCanonicalizing([2, 4, 6], $result->all());
});

test('Test Map Spread', function () {
    $collection = collect([["Eko", "Kurniawan"], ["Khannedy", "Setiawan"]]);
    $result = $collection->mapSpread(function ($firstName, $lastName) {
        return $firstName . " " . $lastName;
    });

    $this->assertEqualsCanonicalizing(["Eko Kurniawan", "Khannedy Setiawan"], $result->all());
});

test('Test Map To Groups', function () {
    $collection = collect([
        ['name' => 'Eko', 'department' => 'IT'],
        ['name' => 'Khannedy', 'department' => 'IT'],
        ['name' => 'Budi', 'department' => 'HR']
    ]);

    $result = $collection->mapToGroups(function ($person) {
        return [$person['department'] => $person['name']];
    });

    $this->assertEquals([
        'IT' => collect(['Eko', 'Khannedy']),
        'HR' => collect(['Budi'])
    ], $result->all());
});

test('Test Zip', function () {
    $collection1 = collect([1, 2, 3]);
    $collection2 = collect([4, 5, 6]);
    $collection3 = $collection1->zip($collection2);

    $this->assertEquals([
    collect([1, 4]), 
    collect([2, 5]), 
    collect([3, 6])], 
    $collection3->all());
});

test('Test Concat', function () {
    $collection1 = collect([1, 2, 3]);
    $collection2 = collect([4, 5, 6]);
    $result = $collection1->concat($collection2);

    $this->assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6], $result->all());
});

test('Test Combine', function () {
    $collection1 = collect(['name', 'country']);
    $collection2 = collect(['Eko', 'Indonesia']);
    $collection3 = $collection1->combine($collection2);

    $this->assertEquals([
        'name' => 'Eko',
        'country' => 'Indonesia',
    ], $collection3->all());
});

test('Test Collapse', function () {
    $collection = collect([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
    $result = $collection->collapse();

    $this->assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
});

test('Test Flat Map', function () {
    $collection = collect([[
        "name" => "Eko",
        "hobbies" => ["Coding", "Gaming"],
    ],
    [
        "name" => "Khannedy",
        "hobbies" => ["Reading", "Writing"],
    ]]);

    $result = $collection->flatMap(function ($item) {
        $hobbies = $item['hobbies'];
        return $hobbies;
    });

    $this->assertEqualsCanonicalizing(["Coding", "Gaming", "Reading", "Writing"], $result->all());
});

test('Test Join', function () {
    $collection = collect(['Eko', 'Khannedy', 'Khannedy']);

    $this->assertEquals('Eko-Khannedy-Khannedy', $collection->join('-'));
    $this->assertEquals('Eko-Khannedy_Khannedy', $collection->join('-', '_'));
    $this->assertEquals('Eko, Khannedy and Khannedy', $collection->join(', ', ' and '));
});

test('Test Filter', function () {
    $collection = collect([
        "Eko" => 100, 
        "Khannedy" => 90, 
        "Budi" => 80
    ]);
    $result = $collection->filter(function ($value) {
        return $value >= 90;
    });

    $this->assertEquals([
        "Eko" => 100, 
        "Khannedy" => 90
    ], $result->all());
});

test('Test Filter Index', function () {
    $collection = collect([1 ,2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10]);
    $result = $collection->filter(function ($value, $key) {
        return $value % 2 === 0;
    });

    $this->assertEqualsCanonicalizing([
        2, 4, 6, 8, 10
    ], $result->all());
});

test('Test Partition', function () {
    $collection = collect([
        "Eko" => 100, 
        "Budi" => 80,
        "Joko" => 90,
    ]);
    [$result1, $result2] = $collection->partition(function ($value) {
        return $value >= 90;
    });

    $this->assertEquals([
        "Eko" => 100, 
        "Joko" => 90
    ], $result1->all());
    $this->assertEquals([
        "Budi" => 80
    ], $result2->all());
});

test('Test Testing', function () {
    $collection = collect(["Eko", "Kurniawan", "Khannedy"]);
    
    $this->assertTrue($collection->contains("Eko"));
    $this->assertTrue($collection->contains(function ($value) {
        return $value === "Eko";
    }));
});

test('Test Grouping', function () {
    $collection = collect([
        ["name" => "Eko", "department" => "IT"],
        ["name" => "Khannedy", "department" => "IT"],
        ["name" => "Budi", "department" => "HR"]
    ]);

    $result = $collection->groupBy(function ($value, $key) {
        return strtolower($value['department']);
    });

    expect($result->all())->toEqual([
        'it' => collect([
            ["name" => "Eko", "department" => "IT"],
            ["name" => "Khannedy", "department" => "IT"],
        ]),
        'hr' => collect([
            ["name" => "Budi", "department" => "HR"]
        ])
    ]);
});

test('Test Slice', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->slice(3);
    $this->assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

    $result = $collection->slice(3, 2);
    $this->assertEqualsCanonicalizing([4, 5], $result->all());
});

test('Test Take', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->take(3);
    $this->assertEqualsCanonicalizing([1, 2, 3], $result->all());

    $result = $collection->takeUntil(function ($value) {
        return $value == 3;
    }); 
    $this->assertEqualsCanonicalizing([1, 2], $result->all());
});

test('Test Skip', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->skip(3);
    $this->assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

    $result = $collection->skipUntil(function ($value) {
        return $value == 3;
    }); 
    $this->assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());

    $result = $collection->skipWhile(function ($value) {
        return $value < 3;
    });

    $this->assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());
});

test('Test Chunked', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->chunk(3);

    $this->assertEqualsCanonicalizing([1, 2, 3], $result->all()[0]->all());
    $this->assertEqualsCanonicalizing([4, 5, 6], $result->all()[1]->all());
    $this->assertEqualsCanonicalizing([7, 8, 9], $result->all()[2]->all());
});

test('Test First', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->first();
    $this->assertEquals(1, $result);

    $result = $collection->first(function ($value, $key) {
        return $value > 5;
    });
    $this->assertEquals(6, $result);
});

test('Test Last', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->last();
    $this->assertEquals(9, $result);

    $result = $collection->last(function ($value, $key) {
        return $value < 5;
    });
    $this->assertEquals(4, $result);
});

test('Test Random', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->random();
    $this->assertTrue(in_array($result, [1, 2, 3, 4, 5, 6, 7, 8, 9]));
});

test('Test Checking Existence', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $this->assertTrue($collection->isNotEmpty());
    $this->assertFalse($collection->isEmpty());
    $this->assertTrue($collection->contains(8));
    $this->assertFalse($collection->contains(10));
    $this->assertTrue($collection->contains(function ($value, $key) {
        return $value == 8;
    }));
});

test('Test Ordering', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->sort();
    $this->assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());

    $result = $collection->sortDesc();
    $this->assertEqualsCanonicalizing([9, 8, 7, 6, 5, 4, 3, 2, 1], $result->all());
});

test('Test Agregate', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->sum();
    $this->assertEquals(45, $result);

    $result = $collection->avg();
    $this->assertEquals(5, $result);

    $result = $collection->min();
    $this->assertEquals(1, $result);

    $result = $collection->max();
    $this->assertEquals(9, $result);
});

test('Test Reduce', function () {
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $result = $collection->reduce(function ($carry, $item) {
        return $carry + $item;
    });

    $this->assertEquals(45, $result);
});

test('Test Lazy Collection', function () {
    $collection = LazyCollection::make(function () {
        $value = 0;
        while (true) {
            yield $value;
            $value++;
        }
    });

    $result = $collection->take(10);
    $this->assertEqualsCanonicalizing([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
});