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
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        $username = "jonathan";
        $password = "12345";
        self::assertTrue($this->userService->login($username, $password));
    }

    public function testLoginFailed()
    {
        $username = "salaha";
        $password = "salah";
        self::assertFalse($this->userService->login($username, $password));
    }

    public function testLoginWrongPassword()
    {
        $username = "jonathan";
        $password = "salah";
        self::assertFalse($this->userService->login($username, $password));
    }
}
