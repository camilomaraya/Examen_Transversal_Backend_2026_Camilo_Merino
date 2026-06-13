<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="Cliente",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre_comercial", type="string", example="90minutos"),
 *     @OA\Property(property="rut", type="string", example="76.111.222-3"),
 *     @OA\Property(property="direccion", type="string", example="Providencia, Santiago"),
 *     @OA\Property(property="tipo", type="string", enum={"Regular","Preferencial"}, example="Preferencial"),
 *     @OA\Property(property="contacto_nombre", type="string", example="Juan Pérez"),
 *     @OA\Property(property="contacto_email", type="string", example="juan@90minutos.cl"),
 *     @OA\Property(property="porcentaje_oferta", type="number", format="float", example=15.00),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ClienteSchema {}
