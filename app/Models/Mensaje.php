<?php

namespace App\Models;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{

    protected $fillable = ['texto', 'fecha'];
    
    public function clientes() {
        return $this->belongsToMany(Cliente::class);
    }
}
