<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query', '');
        $page = $request->input('page', 1);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->get(env('SERVER_ENDPOINT') . '/api/comment/get-all', [
            'query' => $query,
            'page' => $page
        ]);

        $data = $response->json();
        // dd($data);

        if ($data['statusCode'] == 200) {
            $comments = $data['data'];
            $pagination = $data['pagination'];
        } else {
            $comments = [];
            $pagination = [];
        }

        return view('admin.comments.index', [
            'comments' => $comments,
            'pagination' => $pagination,
            'query' => $query,
        ]);
    }

    public function destroy($id)
    {
        $comment = \App\Models\Comment::find($id);
        $comment->delete();
        return redirect()->back();
    }
}
