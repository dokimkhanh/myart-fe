<?php

namespace App\Http\Controllers;

use App\Models\Art;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class LikeController extends Controller
{
    public function like($id)
    {
        $token = Cookie::get('auth_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $like_respone = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SERVER_ENDPOINT') . '/api/interact/like/' . $id);

        // dd($like_respone);

        if ($like_respone->status() !== 200) {
            return redirect()->route('art.show', $id)->with('success', 'Art liked successfully');
        }

        return redirect()->route('art.show', $id)->with('error', 'Failed to like art');
    }

    public function unlike($id)
    {

        $token = Cookie::get('auth_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $unlike_respone = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SERVER_ENDPOINT') . '/api/interact/unlike/' . $id);

        if ($unlike_respone->status() !== 200) {
            return redirect()->route('art.show', $id)->with('error', 'Failed to unlike art');
        }

        return redirect()->route('art.show', $id)->with('success', 'Art unliked successfully');
    }
}
