@extends("layouts.app")

@section("content")
<div class="container">
<form action="{{route('posts.update',$post['id'])}}" method='post' enctype="multipart/form-data">
    <div class="container">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="">title</label>
            <input type="text" name="title" value="{{$post->title}}">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="">description</label>
            <input type="text" name="discription">
            @error('discription')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="image">Image</label>
            <input type="file" name="image" >
            <img src="{{asset('images/posts_images/'.$post->image)}}" alt="no image" width="100" height="100">
            @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="" class="form-label">post creator</label>
            <select class="form-control" name="auother" id="">
                
                <option value="{{$post->auother}}">{{$post->auother}}</option>
                @foreach ($users as $user)
                    <option value="{{$user->name}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>

        

        <button type="submit" class="btn btn-primary">edit</button>

    </div>
</form>
</div>

@endsection