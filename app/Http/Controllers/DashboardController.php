<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $query = $request->input('query', '');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/art', [
            'page' => $page,
            'query' => $query
        ]);

        $data = $response->json();

        // dd($data);
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
            'query' => $query
        ]);
    }
}
