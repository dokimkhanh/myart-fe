<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/admin/dashboard');

        if ($respone->status() == 200) {
            $data = $respone['data'];
        }

        // dd($data);

        return view('admin.dashboard', [
            'res_data' => $data,
        ]);
    }
}
