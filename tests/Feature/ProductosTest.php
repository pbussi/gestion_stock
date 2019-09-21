<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasico()
    {
        $response = $this->get('/productos');
        $response->assertStatus(200);
        $response2 = $this->get('/producto_nuevo');
        $response2->assertStatus(200);
        $response3 = $this->get('/producto_edit/1');
        $response3->assertStatus(200);






    }



}
