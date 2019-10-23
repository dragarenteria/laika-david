<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    public function departamentos(){
        return $this->hasMany(Departamento::class);
    }
}
