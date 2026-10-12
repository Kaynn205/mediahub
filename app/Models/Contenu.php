<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'categorie', 'description', 'auteur_id'];

    public function auteur()
    {
        return $this->belongsTo(Auteur::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
}
