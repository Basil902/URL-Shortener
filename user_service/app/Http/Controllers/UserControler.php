<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class UserControler extends Controller
{
    public function profile() {
        $user = Auth::user();
        $userId = $user->id;

        # api request to the shorten service to retrieve the user's links
        $response = Http::get("http://shorten-service:5001/api/getlinks/{$userId}");
        $links = null;
        // Get the response body

        if ($response->successful()){
            $data = $response->json();
            $links = $data['user_links'] ? $data['user_links'] : [];
        }

        # List the user's links
        return view('profile', ['user' => $user, 'links' => $links]);
    }
}
