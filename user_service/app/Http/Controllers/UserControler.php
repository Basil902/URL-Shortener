<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class UserControler extends Controller
{
    public function profile() {
        $user = Auth::user();
        $userId = Auth::id();

        $response = Http::get("http://localhost:5001/api/getlinks/{$userId}");

        // Get the response body
        $data = $response->json();
        $links = $data['user_links'];

        #die links des eingeloggten Users anzeigen
        return view('profile', ['user' => $user, 'links' => $links]);
    }
}
