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
        Schema::create('imagenes_has_hoteles', function (Blueprint $table) {
            $table->unsignedBigInteger('imagens_id');
            $table->foreign('imagens_id')
                ->references('idComen')
                ->on('comentarios')
                ->onDelete('cascade');

            $table->unsignedBigInteger('hoteles_idHoteles');
            $table->foreign('hoteles_idHoteles')
                ->references('idHoteles')
                ->on('hoteles')
                ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes_has_hoteles');
    }
};
