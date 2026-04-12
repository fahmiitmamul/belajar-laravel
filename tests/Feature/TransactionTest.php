<?php

beforeEach(function () {
    DB::delete('delete from categories');
});


it('Test Transaction Success', function () {
    DB::transaction(function () {
        DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
            "GADGET", "Gadget", "Gadget Category", "2020-10-10 10:10:10"
        ]);

        DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
            "FOOD", "Food", "Food Category", "2020-10-10 10:10:10"
        ]);
    });

    $results = DB::select("select * from categories");
    self::assertCount(2, $results);
});


it('Test Transaction Failed', function () {
    try {
        DB::transaction(function () {
            DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
                "GADGET", "Gadget", "Gadget Category", "2020-10-10 10:10:10"
            ]);

            DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
                "GADGET", "Food", "Food Category", "2020-10-10 10:10:10"
            ]);
        });
    } catch (Exception $e) {
        // Do nothing
    }

    $results = DB::select("select * from categories");
    self::assertCount(0, $results);
});

it('Test Manual Transaction Success', function () {
    
    try {
        DB::beginTransaction();
        DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
            "GADGET", "Gadget", "Gadget Category", "2020-10-10 10:10:10"
        ]);

        DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
            "FOOD", "Food", "Food Category", "2020-10-10 10:10:10"
        ]);

        DB::commit();
    } catch (Exception $e) {
        DB::rollBack();
    }

    $results = DB::select("select * from categories");
    self::assertCount(2, $results);
});

it('Test Manual Transaction Failed', function () {
    
    try {
        DB::beginTransaction();
        DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
            "GADGET", "Gadget", "Gadget Category", "2020-10-10 10:10:10"
        ]);

        DB::insert('insert into categories(id, name, description, created_at) values (?, ?, ?, ?)', [
            "GADGET", "Food", "Food Category", "2020-10-10 10:10:10"
        ]);

        DB::commit();
    } catch (Exception $e) {
        DB::rollBack();
    }

    $results = DB::select("select * from categories");
    self::assertCount(0, $results);
});