<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="Talla",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="M"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class TallaSchema {}
