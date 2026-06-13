<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/health",
 *     tags={"Health"},
 *     summary="Verificar estado del servicio",
 *     description="Endpoint de observabilidad. Verifica que la API está disponible.",
 *     @OA\Response(response=200, description="Servicio operativo",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="online"),
 *             @OA\Property(property="service", type="string", example="TodoCamisetas API"),
 *             @OA\Property(property="version", type="string", example="1.0.0"),
 *             @OA\Property(property="timestamp", type="string", format="date-time")
 *         )
 *     )
 * )
 */
class HealthController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'status'    => 'online',
            'service'   => 'TodoCamisetas API',
            'version'   => '1.0.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
