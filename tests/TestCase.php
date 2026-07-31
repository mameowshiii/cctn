<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        // Force APP_URL to http://localhost during testing to bypass Windows system environment variables
        $_ENV['APP_URL'] = 'http://localhost';
        $_SERVER['APP_URL'] = 'http://localhost';
        putenv('APP_URL=http://localhost');

        // Force SQLite in-memory database to bypass Windows environment variables
        $_ENV['DB_CONNECTION'] = 'sqlite';
        $_SERVER['DB_CONNECTION'] = 'sqlite';
        putenv('DB_CONNECTION=sqlite');

        $_ENV['DB_DATABASE'] = ':memory:';
        $_SERVER['DB_DATABASE'] = ':memory:';
        putenv('DB_DATABASE=:memory:');

        parent::setUp();
    }
}
