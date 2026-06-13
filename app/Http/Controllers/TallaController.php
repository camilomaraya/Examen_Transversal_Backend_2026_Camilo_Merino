<?php

namespace App\Http\Controllers;

use App\Models\Talla;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TallaController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/tallas",
     *     tags={"Tallas"},
     *     summary="Listar todas las tallas",
     *     @OA\Response(response=200, description="Listado de tallas",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Talla"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->successResponse(Talla::all());
    }

    /**
     * @OA\Post(
     *     path="/tallas",
     *     tags={"Tallas"},
     *     summary="Crear una talla",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/TallaInput")),
     *     @OA\Response(response=201, description="Talla creada",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Talla")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:10|unique:tallas,nombre',
        ]);

        $talla = Talla::create($validated);

        return $this->successResponse($talla, 201);
    }

    /**
     * @OA\Get(
     *     path="/tallas/{id}",
     *     tags={"Tallas"},
     *     summary="Obtener una talla con sus camisetas",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Detalle de talla",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Talla")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Talla no encontrada")
     * )
     */
    public function show(int $id)
    {
        $talla = Talla::with('camisetas')->find($id);

        if (!$talla) {
            return $this->errorResponse('Talla no encontrada', 404);
        }

        return $this->successResponse($talla);
    }

    /**
     * @OA\Put(
     *     path="/tallas/{id}",
     *     tags={"Tallas"},
     *     summary="Actualizar una talla",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/TallaInput")),
     *     @OA\Response(response=200, description="Talla actualizada",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Talla")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Talla no encontrada"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(Request $request, int $id)
    {
        $talla = Talla::find($id);

        if (!$talla) {
            return $this->errorResponse('Talla no encontrada', 404);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:10|unique:tallas,nombre,' . $id,
        ]);

        $talla->update($validated);

        return $this->successResponse($talla);
    }

    /**
     * @OA\Delete(
     *     path="/tallas/{id}",
     *     tags={"Tallas"},
     *     summary="Eliminar una talla",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Talla eliminada"),
     *     @OA\Response(response=404, description="Talla no encontrada")
     * )
     */
    public function destroy(int $id)
    {
        $talla = Talla::find($id);

        if (!$talla) {
            return $this->errorResponse('Talla no encontrada', 404);
        }

        $talla->delete();

        return $this->successResponse(null);
    }
}
