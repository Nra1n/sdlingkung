<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot sederhana: robot biasanya mengisi semua input.
        if (filled($request->input('website'))) {
            return redirect()->route('kontak')->with('success', 'Pesan Anda telah kami terima.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ], [], [
            'name' => 'nama',
            'phone' => 'nomor telepon',
            'subject' => 'subjek',
            'message' => 'pesan',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('kontak')->with(
            'success',
            'Terima kasih, '.$validated['name'].'. Pesan Anda sudah tersimpan dan akan kami balas melalui email.'
        );
    }
}
