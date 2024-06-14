<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMailable;

// Controller for the contact form
class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    // Method to store the contact form data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Send an email with the contact form data
        Mail::to('ruizmartinsergio0@gmail.com')
                ->send(new ContactMailable($request->all()));
        session()->flash('success', 'Mensaje enviado correctamente.');

        return redirect()->route('contact.index');
    }
}
