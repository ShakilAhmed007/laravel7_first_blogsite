@extends('layouts.app')
@section('content')
      <h1>Edit Post</h1>
      <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-group">
            <label for="title">Title</label>
            <input value="{{ $post->title }}" type="text" name="title" id="title" class=" form-control">
      </div>
      <div class="form-group">
            <div class="form-group">
              <label for="body">Post</label>
              <textarea class="form-control" name="body" id="body" rows="5">{{ $post->body }}</textarea>
            </div>
      </div>
      <div class="form-group">
            <img width="300px" height="300px" style="object-fit: cover" src="/storage/cover_images/{{ $post->cover_image }}" alt="">
            <input type="file" name="cover_image" id="image" class="form-control" placeholder="" aria-describedby="helpId">
          </div>
      <input type="submit" value="Post">
      </form>
@endsection
