<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post = Post::create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return response()->json($post->load(['user', 'likes', 'comments.user']), 201);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'likes', 'comments.user'])->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('images', 'public');
        }

        $post->content = $request->content;
        $post->save();

        return response()->json($post->load(['user', 'likes', 'comments.user']));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}
?>