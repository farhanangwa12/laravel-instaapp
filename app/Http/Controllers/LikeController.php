<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $userId = $request->user()->id;

        $like = Like::where('user_id', $userId)->where('post_id', $postId)->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Post unliked']);
        }

        Like::create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);

        return response()->json(['message' => 'Post liked']);
    }
}
?>