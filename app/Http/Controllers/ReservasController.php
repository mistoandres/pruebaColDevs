<?php

namespace App\Http\Controllers;

use App\Models\Reservas;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Reservas",
 *     description="Operaciones relacionadas con las reservas."
 * )
 */

class ReservasController extends Controller
{
    //Crear una reserva para un tour.

    /**
     * @OA\Post(
     *     path="/api/reservas/create",
     *     summary="Crear una nueva reserva.",
     *     tags={"Reservas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id_tour", type="number"),
     *             @OA\Property(property="usuario", type="string"),
     *             @OA\Property(property="fecha_reserva", type="string", format="date"),
     *             @OA\Property(property="cantidad_personas", type="number")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Reserva creada exitosamente."),
     *     @OA\Response(response="500", description="Error interno del servidor.")
     * )
     */
    public function create(Request $request)
    {
        try {
            $data['id_tour'] = $request['id_tour'];
            $data['usuario'] = $request['usuario'];
            $data['fecha_reserva'] = $request['fecha_reserva'];
            $data['cantidad_personas'] = $request['cantidad_personas'];
            $res = Reservas::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //Listar todas las reservas de un usuario.

    /**
     * @OA\Get(
     *     path="/api/reservas/{usuario}",
     *     summary="Obtener las reservas de un usuario por campo usuario.",
     *     tags={"Reservas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Reservas listadas con exito."),
     *     @OA\Response(response="500", description="Error interno del servidor.")
     * )
     */
    public function getByUsuario(Request $request)
    {
        $usuario = $request->usuario;
        try {
            $data = Reservas::where("usuario", $usuario)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //Cancelar una reserva.

    /**
     * @OA\Delete(
     *     path="/api/reservas/{id}",
     *     summary="Cancelar una reserva por su ID.",
     *     tags={"Reservas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Reserva cancelada exitosamente."),
     *     @OA\Response(response="500", description="Error interno del servidor.")
     * )
     */
    public function delete($id)
    {
        try {
            $reserva = Reservas::findOrFail($id);
            $reserva->delete();
            return response()->json(["deleted" => $reserva], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
