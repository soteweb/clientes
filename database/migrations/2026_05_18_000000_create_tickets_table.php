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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->string('codigo')->unique(); // ej: TKT-1001
            $table->unsignedInteger('cliente_id');
            $table->string('asunto');
            $table->text('mensaje');
            $table->string('prioridad')->default('Media'); // Alta, Media, Baja
            $table->string('estado')->default('Abierto'); // Abierto, En Proceso, Resuelto
            $table->text('observaciones_admin')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
