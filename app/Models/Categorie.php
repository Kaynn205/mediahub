<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['nom'];
    public function contenus()
    {
        return $this->belongsToMany(Contenu::class);
    }
}
