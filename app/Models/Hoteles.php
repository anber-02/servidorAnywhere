<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoteles extends Model
{
    protected $primaryKey = 'idHoteles';
    use HasFactory;

    public function comentarios(){
        return $this->belongsToMany(Comentarios::class, 'comentarios_has_hoteles','hoteles_idHoteles','comentarios_idComen');
    }


    protected static function newFactory()
    {
        return \Database\Factories\HotelFactory::new();
    }
}
