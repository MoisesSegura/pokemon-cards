<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cartas', [PokemonController::class, 'obtenerCartas']);
Route::get('/buscar', [PokemonController::class, 'buscarPorNombre']);