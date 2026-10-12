<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contenu extends Model
{
    use HasFactory;
    protected $fillable = ['titre','categorie','description','auteur_id'];

    public function auteur(){
        return $this->belongsTo(Auteur::class);
    }   
    public function categories(){
        return $this->belongsToMany(Categorie::class);
    }
}
