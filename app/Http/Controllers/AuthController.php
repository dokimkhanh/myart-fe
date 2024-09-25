<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(env('SERVER_ENDPOINT') . '/api/auth/register', [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
        ]);

        // dd($response);
        if ($response->status() == 200) {
            $user = $response->json()['data'];
        } else {
            return redirect()->back()->with('error', 'Failed to create user');
        }
        return redirect()->route('dashboard')->with('success', 'Welcome, ' . $user['user']['name'] . '! Your account has been created successfully');
    }

    public function login()
    {
        return view('auth.login');
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(env('SERVER_ENDPOINT') . '/api/auth/login', [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        $data = $response->json();
        // dd($data);

        if ($response->status() == 200) {

            Cookie::queue(Cookie::make('auth_token',  $data['data']['token'], 10080));
            session(['auth_user' => $data['data']['user']]);
            session()->save();

            return redirect()->route('dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function register()
    {
        return view('auth.register');
    }


    public function logout(Request $request)
    {
        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->post(env('SERVER_ENDPOINT') . '/api/auth/logout');

        $cookie = Cookie::forget('auth_token');

        session()->forget('auth_user');
        session()->save();

        return redirect()->route('dashboard')->with('success', 'User logged out successfully')->withCookie($cookie);
    }


    public function createUsername($fullName)
    {
        $cleanName = strtolower(trim($fullName));
        $username = str_replace(' ', '', $cleanName);
        $username .= '_' . rand(1000, 9999);
        return $username;
    }
}
