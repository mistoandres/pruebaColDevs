<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Tours;

class ToursControllerTest extends TestCase
{
    public function test_get_all_tours()
    {
        // Simula una solicitud GET al endpoint del controlador 'get'
        $response = $this->get('/api/tours');

        // Verifica que la respuesta tenga el código de estado HTTP 200
        $response->assertStatus(200);

        // Convierte el contenido JSON de la respuesta en un array
        $data = $response->json();

        // Verifica que el número de tours devueltos en la respuesta sea correcto
        $this->assertCount(30, $data); // Se ajusta a la cantidad de tours creados en la base de datos

        // Verifica que la estructura de los datos
        $response->assertJsonStructure([
            '*' => ['id', 'nombre', 'descripcion', 'fecha', 'precio', 'created_at', 'updated_at'],
        ]);
    }

    public function test_create_new_tour()
    {
        // Datos de prueba para crear un nuevo tour
        $requestData = [
            'nombre' => 'Nombre test',
            'descripcion' => 'Nueva descripción del tour - test',
            'fecha' => '2024-02-14',
            'precio' => '123.45'
        ];

        // Simulamos una solicitud POST al endpoint '/api/tours' con los datos de creación
        $response = $this->post('/api/tours/create', $requestData);

        // Verificamos que la respuesta tenga el código de estado HTTP 201 (Created)
        $response->assertStatus(201);

        // Verificamos que el nuevo tour haya sido creado en la base de datos
        $this->assertDatabaseHas('tours', $requestData);

        // Eliminamos el dato de prueba creado
        $tour = Tours::where($requestData)->first();
        $tour->delete();
    }

    public function test_get_tour_by_id()
    {
        // Creamos un tour para actualizar
        $tour = Tours::factory()->create();

        // Simulamos una solicitud GET al endpoint '/api/tours/{id}' con el ID del tour creado
        $response = $this->get("/api/tours/{$tour->id}");

        // Verifica que la respuesta tenga el código de estado HTTP 200
        $response->assertStatus(200);

        // Convertimos el contenido JSON de la respuesta en un array asociativo
        $data = $response->json();

        // Verificamos que los datos devueltos correspondan al tour creado
        $this->assertEquals($tour->id, $data['id']);
        $this->assertEquals($tour->nombre, $data['nombre']);
        $this->assertEquals($tour->descripcion, $data['descripcion']);
        $this->assertEquals($tour->fecha, $data['fecha']);
        $this->assertEquals($tour->precio, $data['precio']);
    }

    public function test_update_tour()
    {
        // Creamos un tour para actualizar
        $tour = Tours::factory()->create();

        // Datos de prueba para la actualización
        $updatedData = [
            'nombre' => 'Nombre test',
            'descripcion' => 'Nueva descripción del tour - test',
            'fecha' => '2024-02-14',
            'precio' => '123.45'
        ];

        // Simulamos una solicitud PUT al endpoint '/api/tours/{id}' con los datos de actualización
        $response = $this->put("/api/tours/{$tour->id}", $updatedData);

        // Verificamos que la respuesta tenga el código de estado HTTP 200 (OK)
        $response->assertStatus(200);

        // Volvemos a cargar el tour desde la base de datos después de la actualización
        $updatedTour = Tours::find($tour->id);

        // Verificamos que los datos del tour se hayan actualizado correctamente
        $this->assertEquals($updatedData['nombre'], $updatedTour->nombre);
        $this->assertEquals($updatedData['descripcion'], $updatedTour->descripcion);
        $this->assertEquals($updatedData['fecha'], $updatedTour->fecha);
        $this->assertEquals($updatedData['precio'], $updatedTour->precio);

        // Simulamos una solicitud DELETE al endpoint '/api/tours/{id}' con el ID del tour creado
        $response = $this->delete("/api/tours/{$tour->id}");

        // Verificamos que el tour haya sido eliminado de la base de datos
        $this->assertDatabaseMissing('tours', ['id' => $tour->id]);
    }

    public function test_delete_tour()
    {
        // Se crea un tour de prueba
        $tour = Tours::factory()->create();

        // Simulamos una solicitud DELETE al endpoint '/api/tours/{id}' con el ID del tour creado
        $response = $this->delete("/api/tours/{$tour->id}");

        // Verificamos que la respuesta tenga el código de estado HTTP 200 (OK)
        $response->assertStatus(200);

        // Verificamos que el tour haya sido eliminado de la base de datos
        $this->assertDatabaseMissing('tours', ['id' => $tour->id]);
    }
}
