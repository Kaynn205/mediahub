<?php

namespace App\Http\Controllers;

use App\Models\Contenu;

class CommentaireController extends Controller
{
    public function index($id)
    {
        $contenu = Contenu::findOrFail($id);

        return response()->json([
            'data' => $contenu->commentaires()->get(),
        ], 200);
    }
}