<?php

use Illuminate\Support\Facades\Log;

it('logs basic messages', function () {
    Log::info("Hello Info");
    Log::warning("Hello Warning");
    Log::error("Hello Error");
    Log::critical("Hello Critical");

    expect(true)->toBeTrue();
});

it('logs with context', function () {
    Log::info("Hello Info", ["user" => "khannedy"]);
    Log::info("Hello Info", ["user" => "khannedy"]);
    Log::info("Hello Info", ["user" => "khannedy"]);

    expect(true)->toBeTrue();
});

it('logs with global context', function () {
    Log::withContext(["user" => "khannedy"]);

    Log::info("Hello Info");
    Log::info("Hello Info");
    Log::info("Hello Info");

    expect(true)->toBeTrue();
});

it('logs to specific channel', function () {
    $slackLogger = Log::channel("slack");
    $slackLogger->error("Hello Slack"); // send to slack channel

    Log::info("Hello Laravel"); // default channel

    expect(true)->toBeTrue();
});

it('logs using file handler channel', function () {
    $fileLogger = Log::channel("file");
    $fileLogger->info("Hello File Handler");
    $fileLogger->warning("Hello File Handler");
    $fileLogger->error("Hello File Handler");
    $fileLogger->critical("Hello File Handler");

    expect(true)->toBeTrue();
});