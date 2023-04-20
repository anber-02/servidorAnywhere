<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    protected $primaryKey = 'idComen';
    use HasFactory;
   
    protected $fillable = ["comentario", "usuarios_idUsuarios"];

    public function users(){
        return $this->belongsTo(User::class,'usuarios_idUsuarios');
    }

    public function tiendas(){
        return $this->belongsToMany(Tiendas::class, 'tiendas_has_servicios', 'comentarios_idComen','tiendas_idTiendas');
    }
    public function restaurantes(){
        return $this->belongsToMany(Tiendas::class, 'tiendas_has_servicios', 'comentarios_idComen','tiendas_idTiendas');
    }
    public function hoteles(){
        return $this->belongsToMany(Tiendas::class, 'tiendas_has_servicios', 'comentarios_idComen','tiendas_idTiendas');
    }
    protected static function newFactory()
    {
        return \Database\Factories\ComentarioFactory::new();
    }
}
