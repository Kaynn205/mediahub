<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'email', 'bio', 'user_id'];

    public function contenus()
    {
        return $this->hasMany(Contenu::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
