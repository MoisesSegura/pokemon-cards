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
        ])->get('https://api.pokemontcg.io/v2/cards?page=1&pageSize=250');

        //https://api.pokemontcg.io/v2/cards?pageSize=250
    
        $cartas = $response->json()['data'];
    
        return response()->json($cartas);
    }


    public function buscarPorNombre(Request $request)
    {
        $nombre = $request->query('nombre');
    
        if (!$nombre) {
            return response()->json(['data' => []]);
        }
    
        $response = Http::withHeaders([
            'X-Api-Key' => config('services.pokemon.key'),
        ])->get('https://api.pokemontcg.io/v2/cards', [
            'q' => "name:$nombre",
            'pageSize' => 50
        ]);
    
        return response()->json($response->json());
    }
    
    
}
