@extends("layouts.app")



@section("main")
<a href="{{route('posts.create')}}" class="btn btn-primary">create post</a>
<a href="{{route('posts.archive')}}" class='btn btn-primary'>Archive</a>
<table class="table">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>posted by</th>
        <th>created at</th>
        <th>Actions</th>
    </tr>
    @foreach($index as $post)
    <tr>
    <tr>
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->auother}}</td>
        <td>{{ $post->indexdate }}</td>
        <td>
            <div class="d-flex gap-2">
                <x-button href="{{route('posts.edit', $post->id)}}" class="primary" text="Edit"></x-button>

                <x-button href="{{route('posts.show', $post->id)}}" class="success" text="Show"></x-button>

                <form action="{{route('posts.delete', $post->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <label for=""></label>
                    <button onclick="return confirm('Are you sure to delete?')" type="submit" value="Restore" class="btn btn-danger">Delete</button>
                </form>

            </div>
        </td>
    </tr>
    @endforeach

</table>
{{$index->links('pagination::bootstrap-5')}}
@endsection