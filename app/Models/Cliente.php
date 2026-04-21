<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    return $this->belongsToMany(Mensaje::class);
}
