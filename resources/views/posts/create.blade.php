@extends('layouts.app')
@section('content')
      <h1>Welcome To Laravel!</h1>
      <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class=" form-control">
      </div>
      <div class="form-group">
            <div class="form-group">
              <label for="body">Post</label>
              <textarea class="form-control" name="body" id="body" rows="5"></textarea>
            </div>
      </div>
      <div class="form-group">
        <input type="file" name="cover_image" id="image" class="form-control" placeholder="" aria-describedby="helpId">
      </div>
      <input type="submit" value="Post">
      </form>
@endsection
