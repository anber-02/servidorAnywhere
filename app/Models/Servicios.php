<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $primaryKey = 'idServicios';
    use HasFactory;

    public function tiendas(){
        return $this->belongsToMany(Tiendas::class, 'tiendas_has_servicios', 'servicios_idServicios', 'tiendas_idTiendas');
    }
}
