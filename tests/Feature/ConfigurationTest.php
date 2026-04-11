<?php

test('Test Configuration', function () {
    $firstName = config('contoh.author.first');
    $lastName = config('contoh.author.last');
    $email = config('contoh.email');
    $web = config('contoh.web');

    expect($firstName)->toBe("Eko");
    expect($lastName)->toBe("Khannedy");
    expect($email)->toBe("echo.khannedy@gmail.com");
    expect($web)->toBe("https://www.programmerzamannow.com");
});
