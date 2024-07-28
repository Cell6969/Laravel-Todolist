<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'username' => 'jonathan',
            'password' => '12345',
        ])->assertRedirect('/')
            ->assertSessionHas('username', 'jonathan');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'username' => 'salah',
            'password' => 'salah',
        ])->assertSeeText('Username or Password is Invalid');
    }

    public function testLogout()
    {
        $this->withSession([
            'username' => 'jonathan'
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('username');
    }
}
