<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContenuRequest;
use App\Http\Resources\ContenuResource;
use App\Models\Contenu;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContenuController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $requete = Contenu::with(['auteur', 'categories']);
        if ($categorie = $request->query('categorie')) {
            $requete->where('categorie', $categorie);
        }
        $colonnesTriables = ['titre', 'categorie', 'created_at'];
        $tri = in_array($request->query('tri'), $colonnesTriables)
        ? $request->query('tri')
        : 'titre';
        $ordre = $request->query('ordre') === 'desc' ? 'desc' : 'asc';
        $requete->orderBy($tri, $ordre);

        return ContenuResource::collection($requete->paginate(15));
    }

    public function show($id)
    {
        $contenu = Contenu::with(['auteur', 'categories'])->find($id);

        if (! $contenu) {
            return response()->json(
                ['message' => 'Contenu introuvable.'],
                404
            );
        }

        return new ContenuResource($contenu);
    }

    public function store(StoreContenuRequest $request)
    {
        $contenu = Contenu::create($request->validated());

        return response()->json(['data' => $contenu], 201);
    }

    public function update(StoreContenuRequest $request, Contenu $contenu)
    {
        // $contenu = Contenu::find($id);
        if (! $contenu) {
            return response()->json(
                ['message' => 'Contenu introuvable .'],
                404
            );
        }
        $contenu->update($request->validated());

        return response()->json(['data' => $contenu], 200);
    }

    public function destroy(Contenu $contenu)
    {
        if (! $contenu) {
            return response()->json(
                ['message' => 'Contenu introuvable .'],
                404
            );
        }
        $contenu->delete();

        return response()->json(null, 204);
    }

    public function rechercheVulnerable(Request $request)
    {
        $q = $request->query('q');
        $resultats = Contenu::where('titre', 'like', "%$q%")->get();
        return response()->json(['data' => $resultats], 200);
    }
}
