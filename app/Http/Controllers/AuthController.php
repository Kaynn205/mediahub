<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}
