<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentaireResource;
use App\Models\Commentaire;

class CommentaireController extends Controller
{
    public function index($id)
    {
        $contenu = Commentaire::with($id);
        if (!$contenu) {
            return response()->json(
                ['message' => 'Contenu introuvable.'],
                404
            );
        }
        $commentaires = $contenu->commentaire()->paginante(10);
        return new CommentaireResource($commentaires);
    }
}