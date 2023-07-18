<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts'=> Post::latest()
                ->filter(request(['search', 'category', 'author']))
                ->paginate(6)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {

        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $attibutes = request()->validate([
            'title' => 'required',
            'slug' => 'required|Unique:posts,slug',
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => 'required|Exists:categories,id'
        ]);

        $attibutes['user_id'] = auth()->id();

        Post::create($attibutes);

        return redirect('/')->with('success', 'You just added new post!');
    }



}
