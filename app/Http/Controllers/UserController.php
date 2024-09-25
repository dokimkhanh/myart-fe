<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show($id)
    {
        $user = null;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/user/' . $id);

        if ($response->status() === 200) {
            $user = $response->json()['data'];
        }

        if ($response->status() === 404) {
            return view('shared.404')->with('message', 'User not found');
        }

        $checkFollow = $this->checkIsFollow($id);

        return view('users.show', compact('user', 'checkFollow'));
    }

    public function edit($id)
    {
        if (!session()->get('auth_user')['id'] == $id || session()->get('auth_user')['is_admin'] == false) {
            return redirect()->route('user.show', $id);
        }

        $user = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/user/' . $id)->json()['data'];

        // dd($user);

        return view('users.user-edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validate = $request->validated();
        // dd($validate);
        $base64Image = null;

        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imageContents = file_get_contents($image->getPathname());
            $base64Image = base64_encode($imageContents);
            $base64Image = 'data:' . $image->getMimeType() . ';base64,' . $base64Image;
        }

        $dataToSend = [
            'name' => $request['name'],
            'bio' => $request['bio'],
        ];

        if ($base64Image) {
            $dataToSend['profile_photo'] = $base64Image;
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->put(env('SERVER_ENDPOINT') . '/api/user/update/' . $id, $dataToSend);

        // dd($response);
        if ($response->status() === 200) {
            return redirect()->route('profile')->with('success', 'Profile updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update profile');
    }


    public function profile()
    {
        $check = session()->has('auth_user');

        if (!$check) {
            return redirect()->route('login');
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->get(env('SERVER_ENDPOINT') . '/api/user/profile');

        if ($response->status() === 200) {
            $user = $response['data']['user'][0];
            session(['auth_user' => $user]);
            session()->save();
        } else {
            session()->flush();
            Cookie::queue(Cookie::forget('auth_token'));
            session()->save();
            return redirect()->route('login');
        }

        // dd($user);

        return view('users.show', [
            'user' => $user,
        ]);
    }

    public static function checkIsLike($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->get(env('SERVER_ENDPOINT') . '/api/interact/islike/' . $id);

        // dd($response->json()['is_liked']);
        if ($response->status() === 200) {
            return $response->json()['is_liked'];
        }

        return false;
    }

    public static function checkIsFollow($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->get(env('SERVER_ENDPOINT') . '/api/follow/checkfollow/' . $id);

        if ($response->status() === 200) {
            return $response->json()['isFollowing'];
        }
    }
}
