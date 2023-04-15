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
        Schema::create('comentarios_has_hoteles', function (Blueprint $table) {
            $table->unsignedBigInteger('comentarios_idComen');
            $table->foreign('comentarios_idComen')
                ->references('idComen')
                ->on('comentarios')
                ->onDelete('cascade');
            
            // $table->unsignedBigInteger('comentarios_Usuarios_idUsuarios');
            // $table->foreign('comentarios_Usuarios_idUsuarios')
            //     ->references('usuarios_idUsuarios')
            //     ->on('comentarios')
            //     ->onDelete('cascade'); 

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
        Schema::dropIfExists('comentarios_has_hoteles');
    }
};
