<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservasControllerTest extends TestCase
{
    public function test_create_reserva_for_tour()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_list_reserva_of_users()
    {
    }

    public function test_cancel_reserva()
    {
        
    }
}
