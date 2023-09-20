<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create(){
        return view('post.create');
    }

    public function update(Request $request, Post $post){
        Gate::authorize('test');

        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();
        $post->update($validated);
        $request->session()->flash('message', '更新しました');
        return back();
    }

    public function index(){
        // $posts = Post::all();
        $posts=Post::with('user')->get();
        return view('post.index', compact('posts'));
    }

    public function show(Post $post){
        return view('post.show', compact('post'));
    }

    public function indicate($id){
        $post=Post::find($id);
        return view('post.show', compact('post'));
    }

    public function edit(Post $post){
        return view('post.edit', compact('post'));
    }
}
