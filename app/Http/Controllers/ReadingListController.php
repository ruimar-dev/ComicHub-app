<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReadingList;
use Illuminate\Support\Facades\Http;

class ReadingListController extends Controller
{

    public function index()
    {
        $readingLists = ReadingList::where('user_id', auth()->id())->get();

        $comics = [];
        $timestamp = time();
        $publicKey = "dfb0f50315bf6369eb209d35020cf6f3";
        $privateKey = "b2d45cbb2af82b2028b987c60565c1a73d4c4f52";
        $hash = md5($timestamp . $privateKey . $publicKey);
        foreach ($readingLists as $readingList) {
            // Hacer la llamada a la API de Marvel para obtener los datos del cómic
            $response = Http::get('https://gateway.marvel.com/v1/public/comics/' . $readingList->comic_id, [
                'apikey' => $publicKey,
                'ts' => $timestamp,
                'hash' => $hash,
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'];
                $comic = $data['results'][0];
                $comic['status'] = $readingList->status;
                $comics[] = $comic; // Agrega el cómic a la matriz $comics
            } else {
                return back()->withErrors('Error en la solicitud a la API de Marvel');
            }
        }

        return view('reading_list', compact('comics')); // Devuelve la vista fuera del bucle
    }

    public function add(Request $request)
    {
        $comic = $request->input('comic_id');

        $readingList = new ReadingList;
        $readingList->user_id = auth()->id();
        $readingList->comic_id = $comic;
        $readingList->status = 'unread';
        $readingList->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $status = $request->input('status');

        $readingList = ReadingList::where('user_id', auth()->id())
            ->where('comic_id', $id)
            ->first();

        if ($readingList) {
            $readingList->status = $status;
            $readingList->save();
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $readingList = ReadingList::where('user_id', auth()->id())
            ->where('comic_id', $id)
            ->first();

        if ($readingList) {
            $readingList->delete();
        }

        return redirect()->back();
    }
}