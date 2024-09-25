<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArtRequest;
use App\Http\Requests\UpdateArtRequest;
use App\Models\Art;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class ArtController extends Controller
{
    public function show($id)
    {
        $respone = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/art/' . $id);

        if ($respone->status() === 200) {
            $art = $respone->json()['data'];
        }

       if ($respone->status() === 404) {
           return view('shared.404')->with('message', 'Art not found');
       }

        return view('art.show', [
            'art' => $art,
        ]);
    }

    public function store(CreateArtRequest $request)
    {
        $request->validated();
        $base64Image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContents = file_get_contents($image->getPathname());
            $base64Image = base64_encode($imageContents);
            $base64Image = 'data:' . $image->getMimeType() . ';base64,' . $base64Image;
        }

        $dataToSend = [
            'content' => $request->input('content'),
            'user_id' => session()->get('auth_user')['id'],
        ];

        if ($base64Image) {
            $dataToSend['image'] = $base64Image;
        }

        // dd($dataToSend);
        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
            'Content-Type' => 'application/json',
        ])->post(env('SERVER_ENDPOINT') . '/api/art', $dataToSend);

        // dd($respone);
        if ($respone->status() == 200) {
            return redirect()->route('dashboard')->with('success', 'Art created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create art');
    }

    public function edit($id)
    {

        $respone = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('SERVER_ENDPOINT') . '/api/art/' . $id);

        if ($respone->status() === 200) {
            $art = $respone->json()['data'];
        }

        return view('art.show', [
            'art' => $art,
            'editing' => true
        ]);
    }

    public function update(UpdateArtRequest $request, $id)
    {
        $request->validated();

        $base64Image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContents = file_get_contents($image->getPathname());
            $base64Image = base64_encode($imageContents);
            $base64Image = 'data:' . $image->getMimeType() . ';base64,' . $base64Image;
        }

        $dataToSend = [
            'content' => $request->content,
        ];

        if ($base64Image) {
            $dataToSend['image'] = $base64Image;
        }

        // dd($dataToSend);

        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
            'Content-Type' => 'application/json',
        ])->put(env('SERVER_ENDPOINT') . '/api/art/' . $id, $dataToSend);

        if ($respone->status() === 200) {
            return redirect()->route('art.show', $id)->with('success', 'Art updated successfully');
        }

        return redirect()->route('art.show', $id)->with('error', 'Failed to update art');
    }

    public function destroy($id)
    {
        $art = Http::get(env('SERVER_ENDPOINT') . '/api/art/' . $id);

        if ($art->status() == 404) {
            return redirect()->route('dashboard')->with('error', 'Art not found');
        }


        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->delete(env('SERVER_ENDPOINT') . '/api/art/' . $id);
        return redirect()->route('dashboard')->with('success', 'Art deleted successfully');
    }
}
