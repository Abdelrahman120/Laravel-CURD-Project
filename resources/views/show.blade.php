@extends('layouts.app')

@section('main')

<div class="card" style="width: 18rem;">
  <div class="card-header">
    Post info
  </div>
  Title : {{$show->title}}
</div>
<br>
<div class="card" style="width: 18rem;">
  <div class="card-header">
    post creator info
  </div>
  Author : {{$show->auother}}
  <br>
  Date : {{$show->formatDate}}
  </ul>
</div>
<br>
<h2>Add Comment</h2>
<form class="mt-4" method="POST" action="{{ route('posts.Comments', $show->id) }}">
  @csrf
  <textarea class="form-control mb-3" name="body"></textarea>
  @error('body')
  <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  <select class="form-control mb-3" name="user_id">
    @foreach($users as $user)
    <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
  </select>
  @error('user_id')
  <div class="alert alert-danger">{{ $message }}</div>
  @enderror
  <button class="btn btn-success" type="submit">Add Comment</button>
</form>
<div class="mt-4">
  @foreach($show->comments as $comment)
  <p>{{ $comment->body }}</p>
  <p>Commented by: {{ $comment->user->name }}</p>
  @endforeach
</div>
@endSection