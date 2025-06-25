<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource with optional search.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::with('user')
            ->when($search, function($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                            ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = new Post($validated);
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Post $post)
    {

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Restore a soft deleted post.
     */
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->restore();

        return redirect()->route('posts.index')
            ->with('success', 'Post restored successfully!');
    }

    /**
     * Display a list of trashed posts.
     */
    public function trashed()
    {
        $posts = Post::onlyTrashed()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('posts.trashed', compact('posts'));
    }

    /**
 * Permanently delete a post from storage.
 */
public function forceDelete($id)
{
    // Find the trashed post
    $post = Post::onlyTrashed()->findOrFail($id);

    // Permanently delete
    $post->forceDelete();

    return redirect()->route('posts.trashed')
        ->with('success', 'Post permanently deleted!');
}

/**
 * Store a newly created resource via AJAX.
 */
public function ajaxStore(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $post = Post::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => Auth::id()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Post created successfully!',
        'post' => $post
    ]);
}
/**
 * Show the form for creating a new post via AJAX.
 */
public function ajaxCreate()
{
    return view('posts.ajax-create');
}
}
