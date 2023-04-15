<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurantes extends Model
{
    protected $primaryKey = 'idRestaurantes';
    use HasFactory;

    public function comentarios(){
        return $this->belongsToMany(Comentarios::class, 'comentarios_has_restaurantes','restaurantes_idRestaurantes','comentarios_idComen');
    }


    protected static function newFactory()
    {
        return \Database\Factories\RestauranteFactory::new();
    }
}
