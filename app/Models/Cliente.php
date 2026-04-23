<?php

namespace App\Models;

use App\Models\Mensaje;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellidos', 'email', 'codigo_pais', 'telefono'];


    public function mensajes() {
        return $this->belongsToMany(Mensaje::class);
    }
    
    
}
