<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLogin()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'thariq'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testDoLoginForMember()
    {
        $this->withSession([
            'user' => 'thariq'
        ])->post('/login')
            ->assertRedirect('/');
    }

    public function testSuccessLogin()
    {
        $this->post('/login', [
            'user' => 'thariq',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'thariq');
    }

    public function testBlankValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText('username or password is required');
    }

    public function testWrongUsername()
    {
        $this->post('/login', [
            'user' => 'salah',
            'password' => 'rahasia'
        ])->assertSeeText('username or password is wrong');
    }

    public function testWrongPassword()
    {
        $this->post('/login', [
            'user' => 'thariq',
            'password' => 'salah'
        ])->assertSeeText('username or password is wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'thariq'
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
