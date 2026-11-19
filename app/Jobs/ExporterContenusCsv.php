<?php

namespace App\Jobs;

use App\Models\Contenu;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExporterContenusCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $contenus = Contenu::with('auteur')
            ->withCount('commentaires')
            ->get();

        $flux = fopen('php://temp', 'r+');
        fputcsv($flux, ['titre', 'categorie', 'auteur', 'nombre_commentaires']);

        foreach ($contenus as $contenu) {
            fputcsv($flux, [
                $contenu->titre,
                $contenu->categorie,
                $contenu->auteur?->nom ?? '',
                $contenu->commentaires_count,
            ]);
        }

        rewind($flux);
        $contenuCsv = stream_get_contents($flux);
        fclose($flux);

        Storage::disk('local')->put('exports/contenus.csv', $contenuCsv);
    }
}
