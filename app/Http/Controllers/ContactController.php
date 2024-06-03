<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMailable;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Send email
        Mail::to('ruizmartinsergio0@gmail.com')
                ->send(new ContactMailable($request->all()));
        session()->flash('success', 'Mensaje enviado correctamente.');

        return redirect()->route('contact.index');
    }
}
