<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="CamisetaInput",
 *     required={"titulo","club","pais","tipo","color","precio","codigo_producto"},
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
 *     @OA\Property(property="tallas", type="array", @OA\Items(type="integer"), example={1,2,3})
 * )
 */
class CamisetaInputSchema {}
