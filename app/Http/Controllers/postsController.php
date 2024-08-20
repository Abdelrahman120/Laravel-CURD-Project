<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\post;
use App\database\factories\UserFactory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class postsController extends Controller
{
    function index()
    {
        $post = Post::paginate(5);
        return view("index", ["index" => $post]);
    }

    function show($id)
    {
        $users = User::all();
        $post = post::findorfail($id);
        return view("show", ["show" => $post, "users" => $users]);
    }

    function create()
    {
        $users = User::all();
        return view("create", ["create" => $users]);
    }

    function store(Request $request)
    {
        request()->validate([
            'title' => 'required|min:5|unique:App\Models\post,title',
            'discription' => 'required|min:10',
            'auother' => 'required|exists:App\Models\User,name',
        ]);

        $data = request()->all();
        $title = $data['title'];
        $auother = $data['auother'];


        $post = new post();
        $post->title = $title;
        $post->auother = $auother;
        $post->save();

        return to_route("posts.index");
    }
    function edit($id)
    {
        $users = User::all();
        $posts = Post::all();
        foreach ($posts as $post) {
            if ($post['id'] == $id) {
                return view('edit', ['post' => $post, "users" => $users]);
            }
        }
        return to_route('posts.update');
    }

    function update($id)
    {

        request()->validate([
            'title' => [
                'required','min:5',
                Rule::unique('App\Models\post')->ignore($id),
            ],
            'discription' => 'required|min:10',
            'auother' => 'required|exists:App\Models\User,name',

        ]);
        $post = Post::findOrFail($id);

        $data = request()->all();
        $title = $data['title'];
        $auother = $data['auother'];


        if ($post->id == $id) {
            $post->title = $title;
            $post->auother = $auother;
            $post->save();
        }
        return to_route("posts.index");
    }
    function archive()
    {
        $post = Post::onlyTrashed()->paginate(5);
        return view("archive", ["archive" => $post]);
    }

    function restore($id)
    {
        $post = post::onlyTrashed()->find($id);
        $post->restore();

        return redirect()->route("posts.index");
    }

    function delete($id)
    {
        $post = post::find($id);
        $post->delete();
        return to_route("posts.index");
    }

    function forceDelete($id)
    {
        $post = Post::withTrashed()->find($id);
        $post->forceDelete();
        return to_route('posts.archive');
    }

    function Comments(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|min:5',
            'user_id' => 'required|exists:App\Models\User,id'
        ]);

        $post->comments()->create([
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
        ]);

        return to_route('posts.show', $post->id);
    }
}
