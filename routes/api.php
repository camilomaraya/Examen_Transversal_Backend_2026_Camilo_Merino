<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\CamisetaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TallaController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class);

Route::apiResource('camisetas', CamisetaController::class)
    ->whereNumber('id');

Route::apiResource('clientes', ClienteController::class)
    ->whereNumber('id');

Route::apiResource('tallas', TallaController::class)
    ->whereNumber('id');
