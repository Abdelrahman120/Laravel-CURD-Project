@extends("layouts.app")

@section("main")
<form action="{{route('posts.update',$post['id'])}}" method='post'>
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
@endsection