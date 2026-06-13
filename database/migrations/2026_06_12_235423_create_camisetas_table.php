<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camisetas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 200);
            $table->string('club', 120);
            $table->string('pais', 80);
            $table->string('tipo', 60);
            $table->string('color', 80);
            $table->unsignedInteger('precio');
            $table->unsignedInteger('precio_oferta')->nullable();
            $table->text('detalles')->nullable();
            $table->string('codigo_producto', 40)->unique();
            $table->foreignId('cliente_id')->nullable()
                  ->constrained('clientes')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camisetas');
    }
};
