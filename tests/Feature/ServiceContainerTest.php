<?php

use App\Data\Foo;
use App\Data\Bar;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;

test('Test Dependency', function () {
    $foo1 = $this->app->make(Foo::class); // new Foo()
    $foo2 = $this->app->make(Foo::class); // new Foo()

    self::assertEquals('Foo', $foo1->foo());
    self::assertEquals('Foo', $foo2->foo());
    self::assertNotSame($foo1, $foo2);
});

test('Test Bind', function () {
    $this->app->bind(Person::class, function ($app){
            return new Person("Eko", "Khannedy");
        });

    $person1 = $this->app->make(Person::class); // closure() // new Person("Eko", "Khannedy");
    $person2 = $this->app->make(Person::class); // closure() // new Person("Eko", "Khannedy");
    self::assertEquals('Eko', $person1->firstName);
    self::assertEquals('Eko', $person2->firstName);
    self::assertNotSame($person1, $person2);
});

test('Test Singleton', function () {
    $this->app->singleton(Person::class, function ($app){
            return new Person("Eko", "Khannedy");
        });

    $person1 = $this->app->make(Person::class); // new Person("Eko", "Khannedy"); if not exists
    $person2 = $this->app->make(Person::class); // return existing
    $person3 = $this->app->make(Person::class); // return existing
    $person4 = $this->app->make(Person::class); // return existing
    self::assertEquals('Eko', $person1->firstName);
    self::assertEquals('Eko', $person2->firstName);
    self::assertSame($person1, $person2);
});

test('Test Instance', function () {
    $person = new Person("Eko", "Khannedy");
    $this->app->instance(Person::class, $person);
    $person1 = $this->app->make(Person::class); // $person
    $person2 = $this->app->make(Person::class); // $person
    $person3 = $this->app->make(Person::class); // $person
    $person4 = $this->app->make(Person::class); // $person
    self::assertEquals('Eko', $person1->firstName);
    self::assertEquals('Eko', $person2->firstName);
    self::assertSame($person1, $person2);
});

test('Test Dependency Injection', function () {
    $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });
    $this->app->singleton(Bar::class, function ($app){
        $foo = $app->make(Foo::class);
        return new Bar($foo);
    });
    $foo = $this->app->make(Foo::class);
    $bar1 = $this->app->make(Bar::class);
    $bar2 = $this->app->make(Bar::class);
    self::assertSame($foo, $bar1->foo);
    self::assertSame($bar1, $bar2);
});

test('Test Interface To Class', function () {
    // $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

    $this->app->singleton(HelloService::class, function ($app){
        return new HelloServiceIndonesia();
    });
    $helloService = $this->app->make(HelloService::class);
    self::assertEquals('Halo Eko', $helloService->hello('Eko'));
});