@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">NEW POST</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('admin.posts.update' , $post->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="title">Title</label>
            <input class = "form-control"
                type="text" name="title" id="title" value="{{ old('title' , $post->title)}}">
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea class = "form-control"
                type="text" name="body" id="body">{{ old('body' , $post->body)}}
            </textarea>
        </div>

        <div class="form-group">
            <label class ="d-block" for="path_img">Post image</label>
            @isset($post->path_img)
                <img class ="mb-4"width = "200"src="{{ asset('storage/' . $post->path_img) }}" alt="{{$post->title}}">
                <span>Change:</span>
            @endisset
            <input class = "form-control"
                type="file" name="path_img" id="path_img" accept="image/*">
                
        </div>

        <input class ="btn btn-primary" type="submit" value="Update Post">
    </form>

</div>
@endsection
