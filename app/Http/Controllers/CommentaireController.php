<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContenuResource;
use App\Models\Commentaire;
use App\Models\Contenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Resources\CommentaireResource;
use App\Jobs\NotifierNouveauCommentaire;

class CommentaireController extends Controller
{
    use AuthorizesRequests;

    public function index($id)
    {
        $commentaires = Commentaire::where('contenu_id', $id);
        return CommentaireResource::collection($commentaires->paginate(15));
    }

    public function store(Request $request, int $id)
    {
        $contenu = Contenu::find($id);

        if (!$contenu) {
            return response()->json(['message' => 'Contenu introuvable.'], 404);
        }

        $donnees = $request->validate([
            'texte' => 'required|string|max:1023',
        ]);

        $commentaire = new Commentaire();
        $commentaire->texte = $donnees['texte'];
        $commentaire->contenu_id = $contenu->id;
        $commentaire->user_id = $request->user()->id;
        $commentaire->nom_auteur = $request->user()->name;
        $commentaire->save();

        NotifierNouveauCommentaire::dispatch($commentaire);

        return response()->json(['data' => $commentaire], 201);
    }

    public function destroy(Contenu $contenu, Commentaire $commentaire)
    {
        $commentaire->delete();
        return response()->json(['message' => 'Suppression du commentaire rÃ©ussie.'], 200);
    }
}