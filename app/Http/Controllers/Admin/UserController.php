<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $query = $request->input('query', '');

        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/user/all', [
            'query' => $query,
            'page' => $page,
        ]);

        if ($respone['status'] == 200) {
            $users = $respone['data'];
            $pagination = $respone['pagination'];
        } else {
            $users = [];
            $pagination = [];
        }

        return view('admin.users.index', [
            'users' => $users,
            'pagination' => $pagination,
            'query' => $query,
        ]);
    }
}
