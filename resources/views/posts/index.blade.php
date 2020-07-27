@extends('layouts.app')
@section('content')
    <h2>posts</h2>
    @if (count($posts) > 0 )
        @foreach ($posts as $post)
            <div class="card mt-1">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    <img width="300px" height="300px" style="object-fit: cover" src="/storage/cover_images/{{ $post->cover_image }}" alt="">
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <h4><a href="/posts/{{$post->id}}">{{ $post->title }}</a></h4>
                    <small>Written on {{$post->created_at}}</small>
                  </div>
                </div>
              </div>
            </div>
        @endforeach
        <hr>
        {{ $posts->links() }}
    @endif
@endsection