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
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('solicitante_nombre')->nullable()->after('cliente_id');
            $table->string('solicitante_telefono')->nullable()->after('solicitante_nombre');
            $table->string('solicitante_email')->nullable()->after('solicitante_telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['solicitante_nombre', 'solicitante_telefono', 'solicitante_email']);
        });
    }
};
