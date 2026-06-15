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
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            
            // Si es un cliente registrado (debe coincidir con int signed de la base de datos legacy)
            $table->integer('cliente_id')->nullable();
            
            // Si es un prospecto nuevo
            $table->string('prospecto_nombre')->nullable();
            $table->string('prospecto_contacto')->nullable();
            $table->string('prospecto_email')->nullable();
            
            // Detalles del requerimiento
            $table->string('titulo');
            $table->text('descripcion');
            
            // Urgencia y Planificación
            $table->string('prioridad')->default('Media'); // Urgente, Alta, Media, Baja
            $table->string('estado')->default('Pendiente'); // Pendiente, Evaluando, Presupuestado, Aprobado, En Desarrollo, Completado, Cancelado
            
            $table->date('fecha_solicitud');
            $table->date('fecha_limite')->nullable();
            $table->decimal('estimacion_horas', 8, 2)->nullable();
            $table->decimal('presupuesto_estimado', 12, 2)->nullable();
            
            $table->text('observaciones')->nullable();
            
            $table->timestamps();
            
            // Relación de clave foránea segura
            $table->foreign('cliente_id')->references('cliente_id')->on('clientes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimientos');
    }
};
