<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public function municipios(){
        return $this->hasMany(Municipio::class);
    }

    public function pais(){
        return $this->belongsTo(Pais::class);
    }
}
