<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthControllerTest extends TestCase
{
    use WithFaker;
    /**
     * Register a user
     * @return void
     */
    public function test_user_register()
    {
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);
        $response->assertStatus(201);
    }

    /**
     * Login user
     * @return void
     */
    public function test_user_login()
    {
        // Create a user
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        // Login
        $response = $this->post('/api/login', [
            'email' => $email,
            'password' => $password
        ]);
        $response->assertStatus(200);
    }

        /**
     * Login user
     * @return void
     */
    public function test_user_logout()
    {
        // Create a user
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        // Login
        $response = $this->post('/api/login', [
            'email' => $email,
            'password' => $password
        ]);

        $token = $response->baseResponse->original['token'];

        // Logout
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/logout', []);

        $response->assertStatus(200);
    }
}
