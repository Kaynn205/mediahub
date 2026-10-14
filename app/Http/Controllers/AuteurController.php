<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuteurRequest;
use App\Http\Resources\AuteurResource;
use App\Models\Auteur;
use Illuminate\Http\Request;

class AuteurController extends Controller
{
    public function index(Request $request)
    {
        $nom = $request->query('nom');

        $auteurs = $nom
            ? Auteur::where('nom', $nom)->get()
            : Auteur::all();

        return AuteurResource::collection($auteurs);
    }

    public function show($id)
    {
        $auteur = Auteur::find($id);

        if (! $auteur) {
            return response()->json(
                ['message' => 'Auteur introuvable.'],
                404
            );
        }

        return new AuteurResource($auteur);
    }

    public function store(StoreAuteurRequest $request)
    {
        $auteur = Auteur::create($request->validated());

        return response()->json(['data' => $auteur], 201);
    }

    public function update(StoreAuteurRequest $request, $id)
    {
        $auteur = Auteur::find($id);
        if (! $auteur) {
            return response()->json(
                ['message' => 'Auteur introuvable .'],
                404
            );
        }
        $auteur->update($request->validated());

        return response()->json(['data' => $auteur], 200);
    }

    public function destroy($id)
    {
        $auteur = Auteur::find($id);
        if (! $auteur) {
            return response()->json(
                ['message' => 'Auteur introuvable .'],
                404
            );
        }
        $auteur->delete();

        return response()->json(null, 204);
    }
}
