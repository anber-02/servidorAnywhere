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
        Schema::create('imagens', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');//tienda, producto, etc
            $table->string('public_id');
            $table->string('nombre');//nombre de la imagen
            $table->string('url');
            // $table->unsignedBigInteger('tiendas_id');

            // $table->foreign('tiendas_id')->references('idTiendas')->on('tiendas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagens');
    }
};
