<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_comercial', 150);
            $table->string('rut', 20)->unique();
            $table->string('direccion', 200);
            $table->enum('tipo', ['Regular', 'Preferencial'])->default('Regular');
            $table->string('contacto_nombre', 120);
            $table->string('contacto_email', 150);
            $table->decimal('porcentaje_oferta', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
