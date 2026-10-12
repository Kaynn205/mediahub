<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu_id',
        'nom_auteur',
        'texte',
    ];

    public function contenu()
    {
        return $this->belongsTo(Contenu::class);
    }
}