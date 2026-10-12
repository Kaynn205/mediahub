<?php

namespace Database\Seeders;

use App\Models\Auteur;
use App\Models\Categorie;
use App\Models\Contenu;
use App\Models\Commentaire;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $auteurs = Auteur::factory()->count(10)->create();

        $categories = Categorie::factory()->count(5)->create();

        Contenu::factory()
            ->count(50)
            ->create([
                'auteur_id' => fn() => $auteurs->random()->id
            ])
            ->each(function ($contenu) use ($categories) {
                $contenu->categories()->attach(
                    $categories->random(rand(1, 3))->pluck('id')
                );
            });

        // Générer 2 à 5 commentaires par contenu
        $contenus = Contenu::all();

        foreach ($contenus as $contenu) {
            Commentaire::factory()
                ->count(rand(2, 5))
                ->create([
                    'contenu_id' => $contenu->id,
                ]);
        }
    }
}