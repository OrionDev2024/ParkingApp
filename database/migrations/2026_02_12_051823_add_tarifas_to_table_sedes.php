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
        Schema::table('sedes', function (Blueprint $table) {
            $table->decimal('tarifa_hora_motos')->default(0);
            $table->decimal('tarifa_hora_carros')->default(0);
            $table->decimal('tarifa_minutos_motos')->default(0);
            $table->decimal('tarifa_minutos_carros')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sedes', function (Blueprint $table) {
            //
        });
    }
};
