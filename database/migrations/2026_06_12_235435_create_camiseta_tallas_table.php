<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camiseta_tallas', function (Blueprint $table) {
            $table->foreignId('camiseta_id')->constrained('camisetas')->cascadeOnDelete();
            $table->foreignId('talla_id')->constrained('tallas')->cascadeOnDelete();
            $table->primary(['camiseta_id', 'talla_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camiseta_tallas');
    }
};
