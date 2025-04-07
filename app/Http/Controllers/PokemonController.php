<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function obtenerCartas()
    {
        $apiKey = config('services.pokemon.key');
    
        $response = Http::withHeaders([
            'X-Api-Key' => $apiKey,
        ])->get('https://api.pokemontcg.io/v2/cards?pageSize=250');
    
        $cartas = $response->json()['data'];
    
        return response()->json($cartas);
    }
    
}
