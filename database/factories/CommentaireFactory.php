<?php

namespace Database\Factories;

use App\Models\Contenu;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireFactory extends Factory
{
    public function definition(): array
    {
        return [
            'contenu_id' => Contenu::factory(),
            'nom_auteur' => fake()->name(),
            'texte' => fake()->paragraph(),
        ];
    }
}