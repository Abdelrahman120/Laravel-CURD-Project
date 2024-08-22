<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\post;
use App\database\factories\UserFactory;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class postsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->only('show');
    // }
    public function index()
    {
        $posts = post::paginate(5);
        return view("index", ["index" => $posts]);
    }

    public function show($id)
    {
        $users = User::all();
        $post = post::findOrFail($id);
        return view("show", ["show" => $post, "users" => $users]);
    }

    public function create()
    {
        $users = User::all();
        return view("create", ["create" => $users]);
    }

    public function store(StorePostRequest $request)
{
    $validatedData = $request->validated();
    $post = new post();
    $post->title = $validatedData['title'];
    $post->auother = $validatedData['auother'];
    $post->user_id = auth::id();
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $post->image = $image->store('images', 'posts_images');
    }
    $post->save();
    return to_route('posts.index');
}
    
    
    public function edit($id)
    {
        $users = User::all();
        $post = post::findOrFail($id);
        return view('edit', ['post' => $post, "users" => $users]);
    }

    public function update($id, UpdatePostRequest $request)
{
    $post = post::findOrFail($id);
    if(!Gate::allows('update-post',$post)) {
        abort(403);
    }

    $post = post::findOrFail($id);
    $validatedData = $request->validated();

    $post->title = $validatedData['title'];
    $post->auother = $validatedData['auother']; 
    $post->user_id = auth::id();
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $post->image = $image->store('images', 'posts_images');
    }

    $post->save();

    return to_route('posts.index');
}
    

    public function archive()
    {
        $posts = post::onlyTrashed()->paginate(5);
        return view("archive", ["archive" => $posts]);
    }

    public function restore($id)
    {
        $post = post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return to_route("posts.index");
    }

    public function delete($id)
    {
        $post = post::findOrFail($id);
        $post->delete();

        return to_route("posts.index");
    }

    public function forceDelete($id)
    {
        $post = post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        return to_route('posts.archive');
    }

    public function Comments(Request $request, post $post)
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