<?php

namespace App\Models;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    
    public function clientes() {
        return $this->belongsToMany(Cliente::class);
    }
}
