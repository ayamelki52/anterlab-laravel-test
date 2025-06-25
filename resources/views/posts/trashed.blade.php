@extends('layouts.app')

@section('title', 'Trashed Posts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Trashed Posts</h5>
        <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to Posts</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->deleted_at->format('M d, Y H:i') }}</td>
                        <td>
                            <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Restore</button>
                            </form>
                            <form action="{{ route('posts.force-delete', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Permanently Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">No trashed posts found</td>
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
