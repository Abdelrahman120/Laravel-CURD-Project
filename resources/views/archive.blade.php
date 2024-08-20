@extends("layouts.app")



@section("main")
<table class="table">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>posted by</th>
        <th>created at</th>
        <th>Actions</th>
    </tr>
    @foreach($archive as $post)
    <tr>
    <tr>
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->auother}}</td>
        <td>{{ $post->formatDate }}</td>
        <td>
            <div class="btn-group">
                <form action="{{route('posts.restore', $post->id)}}" method="post">
                    @csrf
                    <label for=""></label>
                    <button type="submit" value="Restore" class="btn btn-success">Restore</button>
                </form>

                <form action="{{route('posts.forceDelete', $post->id)}}" method="post">
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
{{$archive->links('pagination::bootstrap-5')}}
@endsection