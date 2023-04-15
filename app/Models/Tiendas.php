<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiendas extends Model
{
    use  HasFactory;
    protected $primaryKey = 'idTiendas';
    
    protected $fillable = ['nombre', 'direccion', 'contacto_tel', 'contacto_correo'];

    use HasFactory;

    public function comentarios(){
        return $this->belongsToMany(Comentarios::class, 'comentarios_has_tiendas','tiendas_idTiendas','comentarios_idComen');
    }
    public function servicios(){
        return $this->belongsToMany(Servicios::class,'tiendas_has_servicios', 'tiendas_idTiendas','servicios_idServicios');
    }

    public function imagenes(){
        return $this->hasMany(Imagen::class, 'tiendas_id');
    }

    protected static function newFactory()
    {
        return \Database\Factories\TiendaFactory::new();
    }
}
