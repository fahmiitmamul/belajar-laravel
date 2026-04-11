<?php

use Illuminate\Http\UploadedFile;

test('Test Upload', function () {
    $picture = UploadedFile::fake()->image('khannedy.png');

    $this->post('/file/upload', [
        'file' => $picture,
    ])->assertSeeText('OK khannedy.png');
});
