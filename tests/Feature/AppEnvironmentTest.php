<?php

test('app environment test', function () {
    if (app()->environment(['testing', 'prod', 'dev'])) {
        expect(true)->toBeTrue();
    }
});