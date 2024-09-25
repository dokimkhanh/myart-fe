<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Art;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function store(CreateCommentRequest $request, $id)
    {
        $validate = $request->validated();

        $token = Cookie::get('auth_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->post(env('SERVER_ENDPOINT') . '/api/comment', [
            'art_id' => $id,
            'comment' => $validate['comment'],
        ]);

        // dd($respone);

        if ($respone->status() !== 201) {
            return redirect()->route('art.show', $id)->with('error', 'Failed to post comment');
        }

        return redirect()->route('art.show', $id)->with('success', 'Comment posted successfully');
    }

    public function destroy($art_id, $comment_id)
    {
        $respone = Http::withHeaders([
            'Authorization' => 'Bearer ' . Cookie::get('auth_token'),
        ])->delete(env('SERVER_ENDPOINT') . '/api/comment/' . $comment_id);

        // dd($respone);
        if ($respone->status() == 403) {
            return redirect()->route('art.show', $art_id)->with('error', 'You are not authorized to delete this comment');
        }

        if ($respone->status() == 404) {
            return redirect()->route('art.show', $art_id)->with('error', 'Comment not found');
        }

        if ($respone->status() == 500) {
            return redirect()->route('art.show', $art_id)->with('error', 'Failed to delete comment');
        }

        return redirect()->route('art.show', $art_id)->with('success', 'Comment deleted successfully');
    }
}
