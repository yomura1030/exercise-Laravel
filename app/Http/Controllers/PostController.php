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

    public function store(Request $request){
        Gate::authorize('test');

        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();
        $post = Post::create($validated);
        $request->session()->flash('message', '保存しました');
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
}
