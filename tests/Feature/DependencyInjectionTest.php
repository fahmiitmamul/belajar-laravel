<?php

use App\Data\Foo;
use App\Data\Bar;


test('Test Dependency Injection', function () {
    $foo = new Foo();
    $bar = new Bar($foo);

    $this->assertEquals("Foo and Bar", $bar->bar());
});
