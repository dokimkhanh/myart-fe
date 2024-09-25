<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArtController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query', '');
        $page = $request->input('page', 1);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/art', [
            'query' => $query,
            'page' => $page,
        ]);


        // dd($response->json());

        $data = $response->json();
        if ($data['status'] == 200) {
            $arts = $data['data'];
            $pagination = $data['pagination'];
        } else {
            $arts = [];
            $pagination = [];
        }

        return view('admin.arts.index', [
            'arts' => $arts,
            'pagination' => $pagination,
            'query' => $query,
        ]);
    }
}
