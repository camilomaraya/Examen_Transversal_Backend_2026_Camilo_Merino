<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/clientes",
     *     tags={"Clientes"},
     *     summary="Listar todos los clientes",
     *     @OA\Response(response=200, description="Listado de clientes",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Cliente"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->successResponse(Cliente::all());
    }

    /**
     * @OA\Post(
     *     path="/clientes",
     *     tags={"Clientes"},
     *     summary="Crear un cliente",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ClienteInput")),
     *     @OA\Response(response=201, description="Cliente creado",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Cliente")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_comercial' => 'required|string|max:150',
            'rut'              => 'required|string|max:20|unique:clientes,rut',
            'direccion'        => 'required|string|max:200',
            'tipo'             => 'required|in:Regular,Preferencial',
            'contacto_nombre'  => 'required|string|max:120',
            'contacto_email'   => 'required|email|max:150',
            'porcentaje_oferta' => 'nullable|numeric|min:0|max:100',
        ]);

        $cliente = Cliente::create($validated);

        return $this->successResponse($cliente, 201);
    }

    /**
     * @OA\Get(
     *     path="/clientes/{id}",
     *     tags={"Clientes"},
     *     summary="Obtener un cliente con sus camisetas",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Detalle del cliente",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Cliente")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Cliente no encontrado")
     * )
     */
    public function show(int $id)
    {
        $cliente = Cliente::with('camisetas')->find($id);

        if (!$cliente) {
            return $this->errorResponse('Cliente no encontrado', 404);
        }

        return $this->successResponse($cliente);
    }

    /**
     * @OA\Put(
     *     path="/clientes/{id}",
     *     tags={"Clientes"},
     *     summary="Actualizar un cliente",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ClienteInput")),
     *     @OA\Response(response=200, description="Cliente actualizado",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Cliente")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Cliente no encontrado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(Request $request, int $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return $this->errorResponse('Cliente no encontrado', 404);
        }

        $validated = $request->validate([
            'nombre_comercial' => 'sometimes|required|string|max:150',
            'rut'              => 'sometimes|required|string|max:20|unique:clientes,rut,' . $id,
            'direccion'        => 'sometimes|required|string|max:200',
            'tipo'             => 'sometimes|required|in:Regular,Preferencial',
            'contacto_nombre'  => 'sometimes|required|string|max:120',
            'contacto_email'   => 'sometimes|required|email|max:150',
            'porcentaje_oferta' => 'nullable|numeric|min:0|max:100',
        ]);

        $cliente->update($validated);

        return $this->successResponse($cliente);
    }

    /**
     * @OA\Delete(
     *     path="/clientes/{id}",
     *     tags={"Clientes"},
     *     summary="Eliminar un cliente",
     *     description="No se puede eliminar si tiene camisetas asociadas",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Cliente eliminado"),
     *     @OA\Response(response=404, description="Cliente no encontrado"),
     *     @OA\Response(response=409, description="Cliente tiene camisetas asociadas")
     * )
     */
    public function destroy(int $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return $this->errorResponse('Cliente no encontrado', 404);
        }

        if ($cliente->camisetas()->count() > 0) {
            return $this->errorResponse('No se puede eliminar: el cliente tiene camisetas asociadas', 409);
        }

        $cliente->delete();

        return $this->successResponse(null);
    }
}
