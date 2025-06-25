@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create New Post</h5>
    </div>
    <div class="card-body">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <a href="{{ session('redirect') }}">View post</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                Please fix the errors below.
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input
                    type="text"
                    class="form-control @error('title') is-invalid @enderror"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea
                    class="form-control @error('content') is-invalid @enderror"
                    id="content"
                    name="content"
                    rows="5"
                    required
                >{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
