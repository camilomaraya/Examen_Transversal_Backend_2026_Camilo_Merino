<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "TodoCamisetas API",
    description: "API REST para gestión de inventario de camisetas de fútbol y clientes B2B. Proveedor mayorista de camisetas nacionales e internacionales."
)]
#[OA\Server(
    url: "http://localhost:8080/api",
    description: "Servidor de desarrollo local"
)]
#[OA\Tag(name: "Health",    description: "Estado del sistema")]
#[OA\Tag(name: "Camisetas", description: "Gestión de camisetas de fútbol")]
#[OA\Tag(name: "Clientes",  description: "Gestión de clientes B2B")]
#[OA\Tag(name: "Tallas",    description: "Gestión de tallas")]
abstract class Controller
{
    use ApiResponse;
}
