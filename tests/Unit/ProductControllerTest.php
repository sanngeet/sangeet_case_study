<?php

namespace Tests\Unit;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{
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
}
