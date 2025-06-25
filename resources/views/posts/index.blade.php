@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Posts</h5>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('posts.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search posts..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No posts found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
