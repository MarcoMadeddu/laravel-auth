@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Blog Archive</h1>

    @foreach($posts as $post)
        <article>
            <h2>{{$post->title}}</h2>
            <p>{{$post->body}}</p>

            @if(! $loop->last)
                <hr>
            @endif
        </article>
    @endforeach
        <div class="wrap-pagination mt-5 d-flex justify-content-end">
            {{$posts->links()}}
        </div>
</div>
@endsection
