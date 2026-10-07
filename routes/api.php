<?php

use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AuteurController;
use Illuminate\Support\Facades\Route;

Route::get( '/contenus', [ContenuController::class, 'index']) ;
Route::get( '/contenus/{id}', [ContenuController::class, 'show']) ;
Route::post( '/contenus', [ContenuController::class, 'store']) ;
Route::put ( '/contenus/{id}' , [ContenuController::class , 'update']) ;
Route::delete ( '/contenus/{id}' , [ContenuController::class , 'destroy']) ;

Route::get( '/auteurs', [AuteurController::class, 'index']) ;
Route::get( '/auteurs/{id}', [AuteurController::class, 'show']) ;
Route::post( '/auteurs', [AuteurController::class, 'store']) ;
Route::put ( '/auteurs/{id}' , [AuteurController::class , 'update']) ;
Route::delete ( '/auteurs/{id}' , [AuteurController::class , 'destroy']) ;