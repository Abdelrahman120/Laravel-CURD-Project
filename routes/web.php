<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\postsController;
Route::resource('posts', PostsController::class)->where(['post' => '[0-9]+']);

Route::get("/posts", [postsController::class, "index"])->name("posts.index");

Route::get("/show/{id}", [postsController::class, "show"])->name("posts.show");

Route::get("/create", [postsController::class, "create"])->name("posts.create");
Route::post("/create", [postsController::class, "store"])->name("posts.store");

Route::get("/edit/{id}", [postsController::class, "edit"])->name("posts.edit");
Route::put("/edit/{id}", [postsController::class, "update"])->name("posts.update");

Route::delete("/delete/{id}", [postsController::class, "delete"])->name("posts.delete");
Route::delete("/{id}/forceDelete", [postsController::class, "forceDelete"])->name('posts.forceDelete');

Route::get("/archive", [postsController::class, "archive"])->name("posts.archive")->withTrashed();
Route::post("/{id}restore", [postsController::class, "restore"])->name("posts.restore")->withTrashed();

Route::post('/posts/{post}/comment', [PostsController::class, 'Comments'])->name('posts.Comments');
