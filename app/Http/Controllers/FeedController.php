<?php

namespace App\Http\Controllers;

use App\Models\Art;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class FeedController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->input('page', 1);
        $query = $request->input('query', '');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->get(env('SERVER_ENDPOINT') . '/api/feed', [
            'page' => $page,
            'query' => $query,
        ]);

        $data = $response->json();

        if ($data['status'] == 200) {
            $arts = $data['data'];
            $pagination = $data['pagination'];
        } else {
            $arts = [];
            $pagination = [];
        }

        return view('dashboard', [
            'arts' => $arts,
            'pagination' => $pagination,
            'query' => $query,
        ]);
    }
}
