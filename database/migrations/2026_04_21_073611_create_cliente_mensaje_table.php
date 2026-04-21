<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cliente_mensaje', function (Blueprint $table) {
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mensaje_id')->constrained()->cascadeOnDelete();
            $table->primary(['cliente_id', 'mensaje_id']); // clave primaria compuesta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_mensaje');
    }
};
