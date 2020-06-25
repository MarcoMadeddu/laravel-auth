@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Blog Archive</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th colspan="3"> </th>
            </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->created_at}}</td>
                <td>{{$post->updated_at}}</td>
                <td>
                    <a class = "btn btn-success"href="{{route('admin.posts.show' , $post->id)}}">Show</a>
                </td>
                <td>
                    <a class = "btn btn-primary"href="">Edit</a>
                </td>
                <td>
                    <a class = "btn btn-danger"href="">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


        <div class="wrap-pagination mt-5 d-flex justify-content-end">
            {{$posts->links()}}
        </div>
</div>
@endsection
