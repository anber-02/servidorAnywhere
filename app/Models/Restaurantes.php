<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurantes extends Model
{
    protected $primaryKey = 'idRestaurantes';
    use HasFactory;
    protected $fillable = ['nombre', 'direccion', 'contacto_tel', 'contacto_correo'];

    public function comentarios(){
        return $this->belongsToMany(Comentarios::class, 'comentarios_has_restaurantes','restaurantes_idRestaurantes','comentarios_idComen');
    }
    public function imagenes(){
        return $this->belongsToMany(Imagen::class, 'imagenes_has_restaurantes','restaurantes_idRestaurantes','imagens_id');
    }



    protected static function newFactory()
    {
        return \Database\Factories\RestauranteFactory::new();
    }
}
