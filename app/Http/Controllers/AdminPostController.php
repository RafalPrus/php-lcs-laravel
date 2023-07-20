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
        $attibutes = $this->validatePost();



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
        $attibutes = $this->validatePost($post);

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

    protected function validatePost(?Post $post = null): array
    {
        $post ??= new Post();

        $attibutes = request()->validate([
            'title' => 'required',
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => 'required|Exists:categories,id'
        ]);

        return $attibutes;
    }
}
