@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $post->title }}</h5>
        <div>
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <p class="text-muted">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>
    </div>
</div>
@endsection
