<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_register()
    {
        $response = $this->post('/api/register', [
            'name' => "lorem ipsum",
            'email' => 'hello@gmail.com',
            'password' => '345674567',
            'password_confirmation' => '345674567'
        ]);
        $response->assertStatus(201);
    }
}
