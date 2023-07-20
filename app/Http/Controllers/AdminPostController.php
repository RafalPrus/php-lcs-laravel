<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50)
    ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store()
    {
        $attibutes = request()->validate([
            'title' => 'required',
            'thumbnail' => 'required|image',
            'slug' => 'required|Unique:posts,slug',
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => 'required|Exists:categories,id'
        ]);



        $attibutes['user_id'] = auth()->id();
        $attibutes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');

        Post::create($attibutes);

        return redirect('/')->with('success', "You just added new post!");
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post
        ]);
    }

    public function update(Post $post)
    {
        $attibutes = request()->validate([
            'title' => 'required',
            'thumbnail' => 'image',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => 'required|Exists:categories,id'
        ]);

        if (isset($attibutes['thumbnail'])) {
            $attibutes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attibutes);

        return redirect('/admin/posts')->with('success', "Post updated!");
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/admin/posts')->with('success', "Post deleted!");
    }
}
