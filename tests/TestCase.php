<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;
use App\Http\Middleware\VerifyCsrfToken;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        // Disable CSRF middleware for HTTP tests to avoid 419 errors in CI/local
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }
}
