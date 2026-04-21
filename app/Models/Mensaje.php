<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    return $this->belongsToMany(Cliente::class);
}
