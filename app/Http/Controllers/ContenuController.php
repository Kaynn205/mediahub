<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreContenuRequest;
use App\Models\Contenu;


class ContenuController extends Controller
{

    public function index(Request $request)
    {
        $categorie = $request->query('categorie');
        $contenus = $categorie
            ? Contenu::where('categorie', $categorie)->get()
            : Contenu::all();
        return response()->json(['data' => $contenus], 200);
    }


    public function show($id)
    {
        $contenu = Contenu::find($id);
        if (!$contenu) {
            return response()->json(
                ['message' => 'Contenu introuvable .'],
                404
            );
        }
        return response()->json(['data' => $contenu], 200);
    }


    public function store(StoreContenuRequest $request)
    {
        $contenu = Contenu::create($request->validated());
        return response()->json(['data' => $contenu], 201);
    }


    public function update(StoreContenuRequest $request, $id)
    {
        $contenu = Contenu::find($id);
        if (!$contenu) {
            return response()->json(
                ['message' => 'Contenu introuvable .'],
                404
            );
        }
        $contenu->update($request->validated());
        return response()->json(['data' => $contenu], 200);
    }


    public function destroy($id)
    {
        $contenu = Contenu::find($id);
        if (!$contenu) {
            return response()->json(
                ['message' => 'Contenu introuvable .'],
                404
            );
        }
        $contenu->delete();
        return response()->json(null, 204);
    }


    /*private array $contenus = [
        ['id' => 1, 'titre' => 'Introduction au montage video', 'categorie' => 'video'],
        ['id' => 2, 'titre' => 'Recette de cuisine filmee', 'categorie' => 'video'],
        ['id' => 3, 'titre' => 'Portrait en noir et blanc', 'categorie' => ' image'],
        ['id' => 4, 'titre' => 'Interview d un artiste', 'categorie' => 'article'],
    ];*/


    /*public function index()
    {
        return response()->json(['data' => $this->contenus], 200);
    }*/

    /*public function show($id)
    {
        foreach ($this->contenus as $contenu) {
            if ($contenu['id'] == $id) {
                return response()->json(['data' => $contenu], 200);
            }
        }

        return response()->json(['message' => 'Contenu introuvable.'], 404);
    }


    public function index(Request $request)
    {
        $categorie = $request->query('categorie');
        if ($categorie) {
            $resultats = array_values(array_filter(
                $this->contenus,
                fn($contenu) => $contenu['categorie'] === $categorie
            ));
            return response()->json(['data' => $resultats], 200);
        }
        return response()->json(['data' => $this->contenus], 200);
    }*/

    // public function store(StoreContenuRequest $request)
    // {
    // /*$donneesValidees = $request->validate([
    // 'titre' => 'required|string|max:255',
    // 'categorie' => 'required|string',
    // 'description' => 'nullable|string',
    // ]);
    // $nouveauContenu = array_merge(['id' => 99], $donneesValidees);
    // return response()->json(['data' => $nouveauContenu], 201);*/
    // 
    // $donneesValidees = $request->validated();
    // $nouveauContenu = array_merge(['id' => 99], $donneesValidees);
    // return response()->json(['data' => $nouveauContenu], 201);
    // }
}
