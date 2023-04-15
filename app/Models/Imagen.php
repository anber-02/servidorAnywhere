<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'nombre', 'public_id', 'url', 'extension', 'tiendas_id'];

    public function tiendas(){
        return $this->belongsTo(User::class, 'tiendas_id');
    }
}
