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
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username', 50)->unique();
                $table->string('password', 255);
                $table->string('nombre', 100)->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->string('rol', 50)->default('gestor');
            });
        }

        if (!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->increments('cliente_id');
                $table->string('empresa', 255)->nullable();
                $table->string('titular', 255)->nullable();
                $table->string('ruc', 15)->nullable();
                $table->string('telefono', 20)->nullable();
                $table->string('email', 255)->nullable();
                $table->string('direccion', 255)->nullable();
                $table->string('ciudad', 100)->nullable();
                $table->string('estado')->default('Activo');
                $table->text('observacion')->nullable();
            });
        }

        if (!Schema::hasTable('pagos')) {
            Schema::create('pagos', function (Blueprint $table) {
                $table->increments('pago_id');
                $table->date('fecha')->nullable();
                $table->unsignedInteger('cliente_id')->nullable();
                $table->string('servicio', 255)->nullable();
                $table->string('monto', 255)->nullable();
                $table->string('periodicidad')->nullable();
                $table->date('fecha_proximo_pago')->nullable();
                $table->text('observacion')->nullable();
                // Omit state column here, since the migration 2026_05_19_000000_add_estado_to_pagos_table will add it.
                $table->bigInteger('pool_id')->unsigned()->nullable();
                $table->decimal('porcion_recurso', 10, 2)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('usuarios');
    }
};
