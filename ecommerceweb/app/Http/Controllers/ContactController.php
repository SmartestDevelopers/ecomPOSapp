<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        $seoData = [
            'meta_title' => 'Contact Us - ECommerce Store',
            'meta_description' => 'Get in touch with our customer service team. We\'re here to help with your questions and concerns.',
            'canonical_url' => url('/contact'),
        ];

        return view('pages.contact', compact('seoData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        DB::table('contact_messages')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'created_at' => now(),
        ]);

        return redirect()->route('contact.index')
            ->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }
}
