@extends('layouts.app')
@section('content')
<a class="btn btn-primary" href="/posts"><-Go back</a>
    <h1>{{ $post->title }}</h1>
    <img width="300px" height="300px" style="object-fit: cover" src="/storage/cover_images/{{ $post->cover_image }}" alt="">
    <div>
      {!! $post->body !!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}</small>
    @if (!AUTH::guest())
    @if (Auth::user()->id == $post->user_id)   
    <hr>
    <a href="/posts/{{ $post->id }}/edit" class="btn btn-secondary">Edit</a>
    <form class=" float-right" action="{{ route('posts.destroy', $post->id) }}" method="post">
      @csrf
    @method('DELETE')
    <input class="btn btn-danger" type="submit" value="DELETE">
    </form>
    @endif
    @endif
@endsection
<div class="goend"></div>

