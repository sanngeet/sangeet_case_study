<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthControllerTest extends TestCase
{
    /**
     * Register a user
     * @return void
     */
    use WithFaker;
    public function test_user_register()
    {
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertStatus(201);
    }

    /**
     * Login user
     * @return void
     */
    public function test_user_login()
    {
        $response = $this->post('/api/login', [
            'email' => 'sangeet@gmail.com',
            'password' => '12345678'
        ]);
        $response->assertStatus(200);
    }
}
