<?php

namespace App\Http\Controllers;

use App\Models\Tours;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * @OA\Info(
 *     title="Bookings",
 *     version="1.0.0",
 *     description="Descripción de tu API"
 * )
 *  * @OA\Tag(
 *     name="Tours",
 *     description="Operaciones relacionadas con los tours."
 * )
 */

class ToursController extends Controller
{
    //Obtener todos los tours.

    /**
     * @OA\Get(
     *     path="/api/tours",
     *     summary="Obtener todos los tours.",
     *     tags={"Tours"},
     *     @OA\Response(response="200", description="Listado de tours")
     * )
     */
    public function get()
    {
        try {
            $data = Tours::get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //Crear un nuevo tour.

    /**
     * @OA\Post(
     *     path="/api/tours/create",
     *     summary="Crear un nuevo tour.",
     *     tags={"Tours"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string"),
     *             @OA\Property(property="fecha", type="string", format="date"),
     *             @OA\Property(property="precio", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Tour creado exitosamente"),
     *     @OA\Response(response="500", description="Error interno del servidor")
     * )
     */
    public function create(Request $request)
    {
        try {
            $data['nombre'] = $request['nombre'];
            $data['descripcion'] = $request['descripcion'];
            $data['fecha'] = $request['fecha'];
            $data['precio'] = $request['precio'];
            $res = Tours::create($data);
            return response()->json($res, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //Obtener tour por su ID.

    /**
     * @OA\Get(
     *     path="/api/tours/{id}",
     *     summary="Obtener un tour por su ID.",
     *     tags={"Tours"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Datos del tour"),
     *     @OA\Response(response="500", description="Error interno del servidor")
     * )
     */
    public function getById($id)
    {
        try {
            $data = Tours::find($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //Editar tour por su ID.

    /**
     * @OA\Put(
     *     path="/api/tours/{id}",
     *     summary="Actualizar un tour por su ID.",
     *     tags={"Tours"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string"),
     *             @OA\Property(property="fecha", type="string", format="date"),
     *             @OA\Property(property="precio", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Tour actualizado exitosamente"),
     *     @OA\Response(response="500", description="Error interno del servidor")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $data['nombre'] = $request['nombre'];
            $data['descripcion'] = $request['descripcion'];
            $data['fecha'] = $request['fecha'];
            $data['precio'] = $request['precio'];
            Tours::find($id)->update($data);
            $res = Tours::find($id);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //Eliminar tour por su ID.

    /**
     * @OA\Delete(
     *     path="/api/tours/{id}",
     *     summary="Eliminar un tour por su ID.",
     *     tags={"Tours"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Tour eliminado exitosamente"),
     *     @OA\Response(response="500", description="Error interno del servidor")
     * )
     */
    public function delete($id)
    {
        try {
            $res = Tours::find($id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
