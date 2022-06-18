<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CartControllerTest extends TestCase
{
    private $sessionId;

    /**
     * @return void
     * Get cart items by session id
     */
    public function test_cart_index()
    {
        $response = $this->get('/api/cart',[
            'X-AUTH-TOKEN' => "1234567890",
            'Accept' => "application/json"
        ]);
        $response->assertStatus(200);
    }

    /**
     * @return void
     * Add cart item by session id
     */
    use withFaker;
    public function test_cart_store()
    {   
        $this->sessionId = $this->faker->numerify('##########');
        $quantity = $this->faker->numberBetween($min = 1, $max = 10);
        $productId = $this->faker->numberBetween($min = 1, $max = 15);

        $response = $this->json('POST', '/api/cart', 
        [
            'productId' => $productId,
            'quantity' => $quantity
        ], [
            'X-AUTH-TOKEN' => $this->sessionId,
            'Accept' => "application/json"
        ]);
      
        $response->assertStatus(201);
    }

    /**
     * @return void
     * Update cart item by session id
     */
    use WithFaker;
    public function test_cart_update()
    {   
        $this->sessionId = $this->faker->numerify('##########');
        $quantity = $this->faker->numberBetween($min = 1, $max = 10);
        $productId = $this->faker->numberBetween($min = 1, $max = 15);

        // Add item to cart by sessionId
        $response = $this->json('POST', '/api/cart', 
        [
            'productId' => $productId,
            'quantity' => $quantity
        ], [
            'X-AUTH-TOKEN' => $this->sessionId,
            'Accept' => "application/json"
        ]);
        
       $cartId = $response->baseResponse->original->id;

        // Update the cart item by sessionId and cart ID
        $response = $this->json('PUT', '/api/cart/' . $cartId, 
        [
            'quantity' => $quantity
        ], [
            'X-AUTH-TOKEN' => $this->sessionId,
            'Accept' => "application/json"
        ]);
        $response->assertStatus(200);
    }

        /**
     * @return void
     * Delete cart item by cart id and session id
     */
    use WithFaker;
    public function test_cart_destroy()
    {   
        $this->sessionId = $this->faker->numerify('##########');
        $quantity = $this->faker->numberBetween($min = 1, $max = 10);
        $productId = $this->faker->numberBetween($min = 1, $max = 15);

        // Add item to cart by sessionId
        $response = $this->json('POST', '/api/cart', 
        [
            'productId' => $productId,
            'quantity' => $quantity
        ], [
            'X-AUTH-TOKEN' => $this->sessionId,
            'Accept' => "application/json"
        ]);
        
       $cartId = $response->baseResponse->original->id;

       // Delete by cartId and sessionId
        $response = $this->json('DELETE', '/api/cart/' . $cartId, 
        [], [
            'X-AUTH-TOKEN' => $this->sessionId,
            'Accept' => "application/json"
        ]);
        $response->assertStatus(200);
    }
}
