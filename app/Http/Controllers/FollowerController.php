<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class FollowerController extends Controller
{

    public function follow($id)
    {
        $respone = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->post(env('SERVER_ENDPOINT') . '/api/follow/follow/' . $id);

        // dd($respone);
        if ($respone->status() === 200) {
            return redirect()->route('user.show', $id)->with('success', 'User followed successfully');
        }

        return redirect()->route('user.show', $id)->with('error', 'Failed to follow user');
    }

    public function unfollow($id)
    {

        $respone = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->post(env('SERVER_ENDPOINT') . '/api/follow/unfollow/' . $id);

        if ($respone->status() === 200) {
            return redirect()->route('user.show', $id)->with('error', 'User unfollowed successfully');
        }

        return redirect()->route('user.show', $id)->with('success', 'User unfollowed successfully');
    }
}
