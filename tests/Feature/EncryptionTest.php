<?php

use Illuminate\Support\Facades\Crypt;

test('Encryption Test', function () {
    $encrypt = Crypt::encrypt("Eko Kurniawan");
    var_dump($encrypt);

    $decrypt = Crypt::decrypt($encrypt);
    var_dump($decrypt);

    $this->assertEquals("Eko Kurniawan", $decrypt);
});
