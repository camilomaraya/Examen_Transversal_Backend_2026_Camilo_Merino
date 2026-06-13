<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\Cliente;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CamisetaController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/camisetas",
     *     tags={"Camisetas"},
     *     summary="Listar camisetas",
     *     description="Permite filtrar por cliente_id via query param",
     *     @OA\Parameter(name="cliente_id", in="query", required=false, @OA\Schema(type="integer"),
     *         description="Filtrar camisetas por cliente"
     *     ),
     *     @OA\Response(response=200, description="Listado de camisetas",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Camiseta"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Camiseta::with('tallas');

        if ($request->has('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        return $this->successResponse($query->get());
    }

    /**
     * @OA\Post(
     *     path="/camisetas",
     *     tags={"Camisetas"},
     *     summary="Crear una camiseta",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CamisetaInput")),
     *     @OA\Response(response=201, description="Camiseta creada",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Camiseta")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'          => 'required|string|max:200',
            'club'            => 'required|string|max:120',
            'pais'            => 'required|string|max:80',
            'tipo'            => 'required|string|max:60',
            'color'           => 'required|string|max:80',
            'precio'          => 'required|integer|min:0',
            'precio_oferta'   => 'nullable|integer|min:0',
            'detalles'        => 'nullable|string',
            'codigo_producto' => 'required|string|max:40|unique:camisetas,codigo_producto',
            'cliente_id'      => 'nullable|exists:clientes,id',
            'tallas'          => 'nullable|array',
            'tallas.*'        => 'exists:tallas,id',
        ]);

        $tallas = $validated['tallas'] ?? [];
        unset($validated['tallas']);

        $camiseta = Camiseta::create($validated);

        if (!empty($tallas)) {
            $camiseta->tallas()->attach($tallas);
        }

        return $this->successResponse($camiseta->load('tallas'), 201);
    }

    /**
     * @OA\Get(
     *     path="/camisetas/{id}",
     *     tags={"Camisetas"},
     *     summary="Obtener una camiseta con precio final",
     *     description="Si se envía cliente_id y el cliente es Preferencial con precio_oferta definido, precio_final será el precio_oferta. En caso contrario, precio_final será el precio base.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="cliente_id", in="query", required=false, @OA\Schema(type="integer"),
     *         description="ID del cliente para calcular precio final"
     *     ),
     *     @OA\Response(response=200, description="Detalle de camiseta con precio_final",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Camiseta")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Camiseta no encontrada")
     * )
     */
    public function show(Request $request, int $id)
    {
        $camiseta = Camiseta::with('tallas', 'cliente')->find($id);

        if (!$camiseta) {
            return $this->errorResponse('Camiseta no encontrada', 404);
        }

        $precioFinal = $camiseta->precio;

        if ($request->has('cliente_id')) {
            $cliente = Cliente::find($request->cliente_id);

            if ($cliente && $cliente->tipo === 'Preferencial' && $camiseta->precio_oferta !== null) {
                $precioFinal = $camiseta->precio_oferta;
            }
        }

        $data = $camiseta->toArray();
        $data['precio_final'] = $precioFinal;

        return $this->successResponse($data);
    }

    /**
     * @OA\Put(
     *     path="/camisetas/{id}",
     *     tags={"Camisetas"},
     *     summary="Actualizar una camiseta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CamisetaInput")),
     *     @OA\Response(response=200, description="Camiseta actualizada",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Camiseta")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Camiseta no encontrada"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(Request $request, int $id)
    {
        $camiseta = Camiseta::find($id);

        if (!$camiseta) {
            return $this->errorResponse('Camiseta no encontrada', 404);
        }

        $validated = $request->validate([
            'titulo'          => 'sometimes|required|string|max:200',
            'club'            => 'sometimes|required|string|max:120',
            'pais'            => 'sometimes|required|string|max:80',
            'tipo'            => 'sometimes|required|string|max:60',
            'color'           => 'sometimes|required|string|max:80',
            'precio'          => 'sometimes|required|integer|min:0',
            'precio_oferta'   => 'nullable|integer|min:0',
            'detalles'        => 'nullable|string',
            'codigo_producto' => 'sometimes|required|string|max:40|unique:camisetas,codigo_producto,' . $id,
            'cliente_id'      => 'nullable|exists:clientes,id',
            'tallas'          => 'nullable|array',
            'tallas.*'        => 'exists:tallas,id',
        ]);

        $tallas = $validated['tallas'] ?? null;
        unset($validated['tallas']);

        $camiseta->update($validated);

        if ($tallas !== null) {
            $camiseta->tallas()->sync($tallas);
        }

        return $this->successResponse($camiseta->load('tallas'));
    }

    /**
     * @OA\Delete(
     *     path="/camisetas/{id}",
     *     tags={"Camisetas"},
     *     summary="Eliminar una camiseta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Camiseta eliminada"),
     *     @OA\Response(response=404, description="Camiseta no encontrada")
     * )
     */
    public function destroy(int $id)
    {
        $camiseta = Camiseta::find($id);

        if (!$camiseta) {
            return $this->errorResponse('Camiseta no encontrada', 404);
        }

        $camiseta->delete();

        return $this->successResponse(null);
    }
}
