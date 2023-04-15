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
        Schema::create('tiendas_has_servicios', function (Blueprint $table) {
            $table->unsignedBigInteger('tiendas_idTiendas');
            $table->foreign('tiendas_idTiendas')
                ->references('idTiendas')
                ->on('tiendas')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('servicios_idServicios');
            $table->foreign('servicios_idServicios')
                ->references('idServicios')
                ->on('servicios')
                ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiendas_has_servicios');
    }
};
