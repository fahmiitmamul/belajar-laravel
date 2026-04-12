<?php

use Illuminate\Support\Facades\Storage;

test('Test Storage', function () {
    $filesystem = Storage::disk('local');

    $filesystem->put('test.txt', 'Eko Kurniawan Khannedy');

    $content = $filesystem->get('test.txt');

    self::assertEquals('Eko Kurniawan Khannedy', $content);
});

test('Test Public', function () {
    $filesystem = Storage::disk('public');

    $filesystem->put('file.txt', 'Eko Kurniawan Khannedy');

    $content = $filesystem->get('file.txt');
    
    self::assertEquals('Eko Kurniawan Khannedy', $content);
});
