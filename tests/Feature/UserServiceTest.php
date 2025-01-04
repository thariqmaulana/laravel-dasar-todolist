<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();//karena turunan testcase phpunit

        $this->userService = $this->app->make(UserService::class);
    }

    public function testSample()
    {
        self::assertTrue(true);
    }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login('thariq', 'rahasia'));
    }

    public function testUsernameNotFound()
    {
        self::assertFalse($this->userService->login('notfound', 'rahasia'));
    }

    public function testWrongPassword()
    {
        self::assertFalse($this->userService->login('thariq', 'salah'));
    }
}
