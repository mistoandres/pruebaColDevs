<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Reservas;
use App\Models\Tours;
use Illuminate\Http\Request;


class ReservasControllerTest extends TestCase
{
    // Prueba unitaria para crear una reserva para un tour.
    public function test_create_reserva_for_tour()
    {
        // Datos de prueba para la reserva
        $data = [
            'id_tour' => 1,
            'usuario' => 'Prueba reserva',
            'fecha_reserva' => '2024-02-14',
            'cantidad_personas' => 20,
        ];

        // Crea una instancia de Request con los datos de prueba
        $request = new Request($data);

        // Ejecuta el método create del controlador
        $controller = new \App\Http\Controllers\ReservasController();
        $response = $controller->create($request);

        // Verifica que la respuesta sea una respuesta JSON con un código 201
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));

        // Verifica que la reserva fue creada correctamente en la base de datos
        $this->assertDatabaseHas('reservas', $data);

        // Limpia los datos de prueba después de la ejecución del test
        Reservas::where($data)->delete();
    }

    //Prueba unitaria para listar todas las reservas de un usuario.
    public function test_list_reserva_of_users()
    {
        // Crea una reserva de prueba
        $usuario = 'Prueba reserva';
        $reserva = Reservas::factory()->create(['usuario' => $usuario]);

        // Obtiene el ID del tour asociado a la reserva
        $id_tour = $reserva->id_tour;

        // Simula una solicitud GET al endpoint '/api/reservas' con el usuario especificado
        $response = $this->get("/api/reservas/$usuario");

        // Verifica que la respuesta sea una respuesta JSON con un código de estado 200 (OK)
        $response->assertStatus(200)
            ->assertJson([$reserva->toArray()]);

        // Limpia los datos de prueba después de la ejecución del test
        $reserva->delete();

        // Elimina el tour asociado a la reserva
        $tour = Tours::find($id_tour);
        if ($tour) {
            $tour->delete();
        }

        // Verifica que el tour haya sido eliminado de la base de datos
        $this->assertDatabaseMissing('tours', ['id' => $id_tour]);
    }
    // Prueba unitaria para cancelar una reserva.
    public function test_cancel_reserva()
    {
        // Crea una reserva de prueba
        $reserva = Reservas::factory()->create();

        // Obtiene el ID del tour asociado a la reserva
        $id_tour = $reserva->id_tour;

        // Simula una solicitud DELETE al endpoint '/api/reservas/{id}' con el ID de la reserva creada
        $response = $this->delete("/api/reservas/{$reserva->id}");

        // Verifica que la respuesta tenga el código de estado HTTP 200
        $response->assertStatus(200);

        // Verifica que la reserva haya sido eliminada de la base de datos
        $this->assertDatabaseMissing('reservas', ['id' => $reserva->id]);

        // Elimina el tour asociado a la reserva
        $tour = Tours::find($id_tour);
        if ($tour) {
            $tour->delete();
        }

        // Verifica que el tour haya sido eliminado de la base de datos
        $this->assertDatabaseMissing('tours', ['id' => $id_tour]);
    }
}
