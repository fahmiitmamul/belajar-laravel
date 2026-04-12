<?php

use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::delete('delete from categories');
});

it('can perform CRUD on categories', function () {
    DB::insert(
        'insert into categories(id, name, description, created_at) values (?, ?, ?, ?)',
        ["GADGET", "Gadget", "Gadget Category", "2020-10-10 10:10:10"]
    );

    $results = DB::select(
        'select * from categories where id = ?',
        ['GADGET']
    );

    expect($results)->toHaveCount(1);
    expect($results[0]->id)->toBe('GADGET');
    expect($results[0]->name)->toBe('Gadget');
    expect($results[0]->description)->toBe('Gadget Category');
    expect($results[0]->created_at)->toBe('2020-10-10 10:10:10');
});