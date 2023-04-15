<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoteles extends Model
{
    protected $primaryKey = 'idHoteles';
    use HasFactory;
    protected $fillable = ['nombre', 'direccion', 'contacto_tel', 'contacto_correo'];

    public function comentarios(){
        return $this->belongsToMany(Comentarios::class, 'comentarios_has_hoteles','hoteles_idHoteles','comentarios_idComen');
    }

    public function imagenes(){
        return $this->belongsToMany(Imagen::class, 'imagenes_has_hoteles','hoteles_idHoteles','imagens_id');
    }


    protected static function newFactory()
    {
        return \Database\Factories\HotelFactory::new();
    }
}
