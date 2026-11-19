<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Commentaire;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifierNouveauCommentaire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(
        public Commentaire $commentaire
    ) {}

    public function handle(): void
    {
        $auteur = $this->commentaire->contenu->auteur;

        Mail::raw(
            " Nouveau commentaire sur \"{ $this -> commentaire -> contenu -> titre }\" :\ n \ n "
                . $this->commentaire->texte,
            function ($message) use ($auteur) {
                $message->to($auteur->email)
                    ->subject('Nouveau commentaire sur MediaHub');
            }
        );
    }
}
