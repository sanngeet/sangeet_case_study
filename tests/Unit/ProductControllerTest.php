<?php

namespace Tests\Unit;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // public function test_product_store()
    // {
    //     $response = $this->get('POST', '/api/products', [
    //         'categoryId' => 1,
    //         'name' => "lorem ipsum",
    //         'price' => 12,
    //         'description' => 'some description',
    //         'avatar' => 'some avatar',
    //         'developerEmail' => 'hello@gmail.com'
    //     ]);
    //     $response->assertStatus(200);
    // }

    public function test_product_index()
    {
        $response = $this->get('/api/products/1');
        $response->assertStatus(200);
    }
}
