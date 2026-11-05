<?php

use App\Http\Controllers\AuteurController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ContenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Routes publiques (Authentification) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Routes publiques (Lecture) ---
Route::get('/contenus', [ContenuController::class, 'index']);
Route::get('/contenus/{id}', [ContenuController::class, 'show']);
Route::get('/auteurs', [AuteurController::class, 'index']);
Route::get('/auteurs/{id}', [AuteurController::class, 'show']);
Route::get('/categories', [CategorieController::class, 'index']);
Route::get('/contenus/{id}/commentaires', [CommentaireController::class, 'index']);

// --- Routes protégées (Écriture & Profil) ---
Route::middleware('auth:sanctum')->group(function () {
    // Informations utilisateur et déconnexion
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Écriture : Contenus
    Route::post('/contenus', [ContenuController::class, 'store']);
    Route::put('/contenus/{id}', [ContenuController::class, 'update']);
    Route::delete('/contenus/{id}', [ContenuController::class, 'destroy']);

    // Écriture : Auteurs
    Route::post('/auteurs', [AuteurController::class, 'store']);
    Route::put('/auteurs/{id}', [AuteurController::class, 'update']);
    Route::delete('/auteurs/{id}', [AuteurController::class, 'destroy']);

    // Écriture : Catégories
    Route::post('/categories', [CategorieController::class, 'store']);
});