@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Post</h5>
    </div>
    <div class="card-body">
<form id="edit-post-form" action="{{ route('posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror"
               id="title" name="title" value="{{ old('title', $post->title) }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control @error('content') is-invalid @enderror"
                  id="content" name="content" rows="5" required>{{ old('content', $post->content) }}</textarea>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

    </div>
</div>

@endsection
