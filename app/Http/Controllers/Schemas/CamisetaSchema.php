<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="Camiseta",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="titulo", type="string", example="Camiseta Local 2025 – Selección Chilena"),
 *     @OA\Property(property="club", type="string", example="Selección Chilena"),
 *     @OA\Property(property="pais", type="string", example="Chile"),
 *     @OA\Property(property="tipo", type="string", example="Local"),
 *     @OA\Property(property="color", type="string", example="Rojo"),
 *     @OA\Property(property="precio", type="integer", example=45000),
 *     @OA\Property(property="precio_oferta", type="integer", nullable=true, example=38000),
 *     @OA\Property(property="detalles", type="string", nullable=true, example="Edición aniversario 2025"),
 *     @OA\Property(property="codigo_producto", type="string", example="SCL2025L"),
 *     @OA\Property(property="cliente_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="precio_final", type="integer", example=38000),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class CamisetaSchema {}
