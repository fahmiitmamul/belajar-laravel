<?php

test('Test Hello', function () {
    $this->get('/controller/hello/eko')
        ->assertSeeText('Halo eko');
});

test('Test Request', function () {
    $this->get('/controller/hello/request', [
            "Accept" => "plain/text"
    ])
    ->assertSeeText("controller/hello/request")
    ->assertSeeText(url('/controller/hello/request'))
    ->assertSeeText("GET")
    ->assertSeeText("plain/text");
});