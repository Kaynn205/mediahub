<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    protected $fillable = ['nom','email','bio'];

    public function contenus(){
        return $this->hasMany(Contenu::class);
    }
}
