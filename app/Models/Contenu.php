<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    protected $fillable = ['titre','categorie','description','auteur_id'];

    public function auteur(){
        return $this->belongsTo(Auteur::class);
    }
    public function contenus(){
        return $this->belongsToMany(Categorie::class);
    }
}
