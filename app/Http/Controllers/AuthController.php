<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $donnees = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            "name" => $donnees["name"],
            "email" => $donnees["email"],
            "password" => Hash::make($donnees["password"]),
        ]);
        $token = $user->createToken("api-token")->plainTextToken;
        return response()->json(["data" => $user, "token" => $token], 201);
    }
    public function login(Request $request)
    {
        $donnees = $request->validate([
            "email" => "required|email",
            "password" => "required|string",
        ]);
        $user = User::where("email", $donnees["email"])->first();
        if (! $user || ! Hash::check($donnees["password"], $user->password)) {
            return response()->json(["message" => "Identifiantsinvalides"], 401);
        }
        $token = $user->createToken("api-token")->plainTextToken;
        return response()->json(["data" => $user, "token" => $token], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "Deconnexion reussie."], 200);
    }
    public function me(Request $request)
    {
        return response()->json([
            'id'    => $request->user()->id,
            'name'  => $request->user()->name,
            'email' => $request->user()->email,
        ], 200);
    }
    public function updatePassword(Request $request)
    {
        // 1. Validation des champs requis et format
        $request->validate([
            'mot_de_passe_actuel' => ['required', 'string'],
            'nouveau_mot_de_passe' => ['required', 'string', 'min:8'],
        ], [
            'nouveau_mot_de_passe.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = $request->user();

        // 2. Vérification du mot de passe actuel
        if (!Hash::check($request->mot_de_passe_actuel, $user->password)) {
            throw ValidationException::withMessages([
                'mot_de_passe_actuel' => ['Le mot de passe actuel est incorrect.'],
            ]);
        }

        // 3. Mise à jour et hachage du nouveau mot de passe
        $user->forceFill([
            'password' => Hash::make($request->nouveau_mot_de_passe),
        ])->save();

        return response()->json([
            'message' => 'Mot de passe modifié avec succès.'
        ], 200);
    }
    public function tokens(Request $request)
    {
        $tokens = $request->user()->tokens->map(function ($token) {
            return [
                'id'   => $token->id,
                'name' => $token->name,
            ];
        });

        return response()->json($tokens, 200);
    }
    public function destroyToken(Request $request, $id)
    {
        // 1. Recherche du jeton parmi la collection de l'utilisateur connecté
        $token = $request->user()->tokens()->where('id', $id)->first();

        // 2. Si le jeton n'existe pas ou n'appartient pas à l'utilisateur
        if (!$token) {
            return response()->json([
                'message' => 'Jeton introuvable ou non autorisé.'
            ], 404);
        }

        // 3. Suppression (révocation) du jeton
        $token->delete();

        return response()->json([
            'message' => 'Le jeton a été révoqué avec succès.'
        ], 200);
    }
}
