<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComicController extends Controller
{
    public function index(Request $request)
    {
        $timestamp = time();
        $publicKey = "dfb0f50315bf6369eb209d35020cf6f3";
        $privateKey = "b2d45cbb2af82b2028b987c60565c1a73d4c4f52";
        $hash = md5($timestamp . $privateKey . $publicKey);
        $limit = 12;

        $response = Http::get("https://gateway.marvel.com/v1/public/comics", [
            'apikey' => $publicKey,
            'ts' => $timestamp,
            'hash' => $hash,
            'limit' => $limit,
            'offset' => 0
        ]);

        if ($response->successful()) {
            $data = $response->json()['data'];
            $comics = collect($data['results'])->filter(function ($comic) {
                $imageUrl = $comic['thumbnail']['path'] . '/portrait_uncanny.' . $comic['thumbnail']['extension'];
                return $imageUrl !== 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available/portrait_uncanny.jpg';
            });

            return view('dashboard', compact('comics'));
        } else {
            return back()->withErrors('Error en la solicitud a la API de Marvel');
        }
    }

    public function loadMore(Request $request)
    {
        $search = $request->search;
        $timestamp = time();
        $publicKey = "dfb0f50315bf6369eb209d35020cf6f3";
        $privateKey = "b2d45cbb2af82b2028b987c60565c1a73d4c4f52";
        $hash = md5($timestamp . $privateKey . $publicKey);
        $limit = 12;
        

        $offset = $request->offset;

        $parameters = [
            'apikey' => $publicKey,
            'ts' => $timestamp,
            'hash' => $hash,
            'limit' => $limit,
            'offset' => $offset
        ];
    
        if ($search) {
            $parameters['titleStartsWith'] = $search;
        }
    
        $response = Http::get("https://gateway.marvel.com/v1/public/comics", $parameters);

        if ($response->successful()) {
            $data = $response->json()['data'];
            $comics = collect($data['results'])->filter(function ($comic) {
                $imageUrl = $comic['thumbnail']['path'] . '/portrait_uncanny.' . $comic['thumbnail']['extension'];
                return $imageUrl !== 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available/portrait_uncanny.jpg';
            });

            return response()->json($comics->values());
        } else {
            return response()->json(['error' => 'Error en la solicitud a la API de Marvel'], 500);
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $timestamp = time();
        $publicKey = "dfb0f50315bf6369eb209d35020cf6f3";
        $privateKey = "b2d45cbb2af82b2028b987c60565c1a73d4c4f52";
        $hash = md5($timestamp . $privateKey . $publicKey);
        $limit = 12;
        $offset = $request->input('offset', 0);


        $response = Http::get('https://gateway.marvel.com/v1/public/comics', [
            'apikey' => $publicKey,
            'ts' => $timestamp,
            'hash' => $hash,
            'limit' => $limit,
            'offset' => $offset,
            'titleStartsWith' => $search,
        ]);

        if ($response->successful()) {
            $data = $response->json()['data'];
            $comics = collect($data['results'])->filter(function ($comic) {
                $imageUrl = $comic['thumbnail']['path'] . '/portrait_uncanny.' . $comic['thumbnail']['extension'];
                return $imageUrl !== 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available/portrait_uncanny.jpg';
            });

            return view('partials.numbers', compact('comics'));
        }else {
            return response()->json(['error' => 'Error en la solicitud a la API de Marvel'], 500);
        }
    }

    public function show($id)
    {
        $timestamp = time();
        $publicKey = "dfb0f50315bf6369eb209d35020cf6f3";
        $privateKey = "b2d45cbb2af82b2028b987c60565c1a73d4c4f52";
        $hash = md5($timestamp . $privateKey . $publicKey);

        $response = Http::get("https://gateway.marvel.com/v1/public/comics/$id", [
            'apikey' => $publicKey,
            'ts' => $timestamp,
            'hash' => $hash,
        ]);

        if ($response->successful()) {
            $data = $response->json()['data'];
            $comic = $data['results'][0];

            // Generar una URL de Amazon basada en el título del cómic
            $marvelUrl = 'https://www.marvel.com/comics/issue/' . $comic['id'] . '/' . $comic['title'] . '?utm_campaign=apiRef&utm_source=' . $publicKey . '&utm_medium=api';

            // Agregar la URL de Amazon al array de URLs del cómic
            $comic['urls'][] = [
                'type' => 'marvel',
                'url' => $marvelUrl
            ];

            return view('comic', compact('comic'));
        } else {
            return back()->withErrors('Error en la solicitud a la API de Marvel');
        }
    }

}