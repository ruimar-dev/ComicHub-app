<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReadingList;
use Illuminate\Support\Facades\Http;

class ReadingListController extends Controller
{

    // Method to show the reading list
    public function index()
    {
        $readingLists = ReadingList::where('user_id', auth()->id())->get();

        $comics = [];
        $timestamp = time();
        $publicKey = "dfb0f50315bf6369eb209d35020cf6f3";
        $privateKey = "b2d45cbb2af82b2028b987c60565c1a73d4c4f52";
        $hash = md5($timestamp . $privateKey . $publicKey);
        foreach ($readingLists as $readingList) {
            // Make a request to the Marvel API to get the comic details
            $response = Http::get('https://gateway.marvel.com/v1/public/comics/' . $readingList->comic_id, [
                'apikey' => $publicKey,
                'ts' => $timestamp,
                'hash' => $hash,
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'];
                $comic = $data['results'][0];
                $comic['status'] = $readingList->status;
                $comics[] = $comic; // Add the comic to the array
            } else {
                return back()->withErrors('Error en la solicitud a la API de Marvel');
            }
        }

        return view('reading_list', compact('comics')); // return the view with the comics
    }

    // Method to add a comic to the reading list
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

    // Method to update the status of a comic in the reading list
    public function update(Request $request, $id)
    {
        $status = $request->input('status');

        // Find the comic in the reading list
        $readingList = ReadingList::where('user_id', auth()->id())
            ->where('comic_id', $id)
            ->first();

        if ($readingList) {
            $readingList->status = $status;
            $readingList->save();
        }

        return redirect()->back();
    }

    // Method to remove a comic from the reading list
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