<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('categories.liste', 600, function () {
            return Categorie::all();
        });

        return response()->json(['data' => $categories], 200);
    }

    public function store(Request $request)
    {
        $donnees = $request->validate(['nom' => 'required | string | max
:255 ']);
        $categorie = Categorie::create($donnees);
        Cache::forget('categories.liste');

        return response()->json(['data' => $categorie], 201);
    }
}
