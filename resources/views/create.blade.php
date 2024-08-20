@extends('layouts.app')

@section('main')
<form action="{{route('posts.store')}}" method="post">
    @csrf
    <div class="container">
        <div class="mb-3">
            <label for="">title</label>
            <input type="text" name="title" value="{{old('title')}}">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        
        <div class="mb-3">
            <label for="">description</label>
            <input type="text" name="discription" value="{{old('discription')}}">
            @error('discription')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="" class="form-label">post creator</label>
            <select class="form-control" name="auother" id="">
                @foreach ($create as $user)
                <option value="{{$user->name}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>

        

        <button type="submit" class="btn btn-primary">create</button>
    </div>
</form>
@endSection