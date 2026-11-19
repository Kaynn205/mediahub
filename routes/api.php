<?php

use App\Http\Controllers\AuteurController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ContenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Routes publiques (Authentification) ---
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
// --- Routes publiques (Lecture) ---
Route::get('/contenus', [ContenuController::class, 'index']);
Route::get('/contenus/{id}', [ContenuController::class, 'show']);
Route::get('/auteurs', [AuteurController::class, 'index']);
Route::get('/auteurs/{id}', [AuteurController::class, 'show']);
Route::get('/categories', [CategorieController::class, 'index']);
Route::get('/contenus/{id}/commentaires', [CommentaireController::class, 'index']);
Route::get('/contenus-recherche', [ContenuController::class, 'rechercheVulnerable']);
// --- Routes protégées (Écriture & Profil) ---
Route::middleware('auth:sanctum')->group(function () {
    // Informations utilisateur et déconnexion
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me/password', [AuthController::class, 'updatePassword']);
    Route::get('/me/tokens', [AuthController::class, 'tokens']);
    Route::delete('/me/tokens/{id}', [AuthController::class, 'destroyToken']);
    Route::post('/logout', [AuthController::class, 'logout']);


    // Écriture : Contenus
    Route::post('/contenus', [ContenuController::class, 'store']);
    // Route::put('/contenus/{id}', [ContenuController::class, 'update']);
    Route::put("/contenus/{contenu}", [ContenuController::class, "update"])->middleware("can:update,contenu");
    Route::delete('/contenus/{contenu}', [ContenuController::class, 'destroy'])->middleware("can:destroy,contenu");
    Route::post('/contenus/{id}/commentaires', [CommentaireController::class, 'store']);
    Route::delete('/contenus/{contenu}/commentaires/{commentaire}', [CommentaireController::class, 'destroy'])->middleware('can:delete,commentaire');
    // Écriture : Auteurs
    Route::post('/auteurs', [AuteurController::class, 'store']);
    Route::put('/auteurs/{id}', [AuteurController::class, 'update']);
    Route::delete('/auteurs/{id}', [AuteurController::class, 'destroy']);

    // Écriture : Catégories
    Route::post('/categories', [CategorieController::class, 'store']);
    Route::get("/me", [AuthController::class, 'index']);
    Route::get("/me/tokens", [AuthController::class, 'indexToken']);
    Route::put("/me/password", [AuthController::class, 'update']);
    Route::delete("/me/tokens/{id}", [AuthController::class, 'destroy']);
});
