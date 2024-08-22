<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = post::all();
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'auother' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new post();
        $post->title = $validatedData['title'];
        $post->auother = $validatedData['auother'];
        $post->user_id = $request->input('user_id');

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('images', 'posts_images');
        }

        $post->save();
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = post::findOrFail($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'auother' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = post::findOrFail($id);
        $post->title = $validatedData['title'];
        $post->auother = $validatedData['auother'];

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('images', 'posts_images');
        }

        $post->save();
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}