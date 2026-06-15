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
        // 1. Crear tabla proveedores si no existe
        if (!Schema::hasTable('proveedores')) {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->id('proveedor_id');
                $table->string('nombre');
                $table->string('contacto')->nullable();
                $table->string('telefono')->nullable();
                $table->string('email')->nullable();
                $table->string('sitio_web')->nullable();
                $table->text('observacion')->nullable();
                $table->timestamps();
            });
        }

        // 2. Crear tabla pools si no existe
        if (!Schema::hasTable('pools')) {
            Schema::create('pools', function (Blueprint $table) {
                $table->id('pool_id');
                $table->unsignedBigInteger('proveedor_id');
                $table->string('nombre');
                $table->decimal('costo', 12, 2)->default(0.00);
                $table->string('periodicidad')->nullable(); // Mensual, Anual, Unico
                $table->date('fecha_compra')->nullable();
                $table->date('fecha_vencimiento')->nullable();
                $table->string('recurso_tipo')->default('Almacenamiento (GB)'); // Almacenamiento (GB), Cuentas / Licencias, Memoria (GB), Otros
                $table->decimal('recurso_capacidad', 10, 2)->default(0.00);
                $table->string('estado')->default('Activo'); // Activo, Suspendido, Cancelado
                $table->text('observacion')->nullable();
                $table->timestamps();

                $table->foreign('proveedor_id')->references('proveedor_id')->on('proveedores')->onDelete('cascade');
            });
        }

        // 3. Modificar tabla pagos si no tiene las columnas
        Schema::table('pagos', function (Blueprint $table) {
            if (!Schema::hasColumn('pagos', 'pool_id')) {
                $table->unsignedBigInteger('pool_id')->nullable()->after('estado');
                $table->foreign('pool_id')->references('pool_id')->on('pools')->onDelete('set null');
            }
            if (!Schema::hasColumn('pagos', 'porcion_recurso')) {
                $table->decimal('porcion_recurso', 10, 2)->nullable()->after('pool_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            if (Schema::hasColumn('pagos', 'pool_id')) {
                $table->dropForeign(['pool_id']);
                $table->dropColumn(['pool_id']);
            }
            if (Schema::hasColumn('pagos', 'porcion_recurso')) {
                $table->dropColumn(['porcion_recurso']);
            }
        });

        Schema::dropIfExists('pools');
        Schema::dropIfExists('proveedores');
    }
};
