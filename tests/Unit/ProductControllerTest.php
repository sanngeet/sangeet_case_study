<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProductControllerTest extends TestCase
{
    use withFaker;
    /**
     * Get all products
     * @return void
     */
    public function test_product_index()
    {
        $response = $this->get('/api/products');
        $response->assertStatus(200);
    }

    /**
     * Get product by ID
     * @return void
     */
    public function test_product_show()
    {
        $response = $this->get('/api/products/1');
        $response->assertStatus(200);
    }

    /**
     * Create product
     * @return void
     */
    public function test_product_store()
    {
        // Create a user
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->asciify('**********');

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);
        $token = $response->baseResponse->original['token'];

        // Create Product
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/products', [
            'categoryId' => $this->faker->numberBetween($min = 1, $max = 8),
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween($min = 1, $max = 99999),
            'description' => $this->faker->text($maxNbChars = 200),
            'avatar' => 'https://picsum.photos/200/300',
            'developerEmail' => $this->faker->email
        ]);
        $response->assertStatus(200);
    }

    /**
     * Update product details
     * @return void
     */
    public function test_product_update()
    {
        // Create a user
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->asciify('**********');

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);
        $token = $response->baseResponse->original['token'];

        //Create Product
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/products', [
            'categoryId' => $this->faker->numberBetween($min = 1, $max = 8),
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween($min = 1, $max = 99999),
            'description' => $this->faker->text($maxNbChars = 200),
            'avatar' => 'https://picsum.photos/200/300',
            'developerEmail' => $this->faker->email
        ]);

        $productId = $response->baseResponse->original->id;

        // Update Product
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/products/'.$productId, [
            'categoryId' => $this->faker->numberBetween($min = 1, $max = 8),
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween($min = 1, $max = 99999),
            'description' => $this->faker->text($maxNbChars = 200),
            'avatar' => 'https://picsum.photos/200/300',
            'developerEmail' => $this->faker->email
        ]);
        $response->assertStatus(200);
    }

    /**
     * Delete product details
     * @return void
     */
    public function test_product_destroy()
    {
        // Create a user
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->asciify('**********');

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);
        $token = $response->baseResponse->original['token'];

        //Create Product
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/products', [
            'categoryId' => $this->faker->numberBetween($min = 1, $max = 8),
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween($min = 1, $max = 99999),
            'description' => $this->faker->text($maxNbChars = 200),
            'avatar' => 'https://picsum.photos/200/300',
            'developerEmail' => $this->faker->email
        ]);

        $productId = $response->baseResponse->original->id;

        // Delete Product
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/products/'.$productId, []);
        $response->assertStatus(200);
    }
}