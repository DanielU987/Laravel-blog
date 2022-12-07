<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(12);
        return view('index', compact('posts'));
    }

    public function page1()
    {
        return view('page1');
    }

    public function show(Post $post)
    {
        return view('show', compact('post'));
    }

    public function page2()
    {
        return view('page2');
    }

    public function tag(Tag $tag)
    {
        $search = request()->query('search');
        $query = $tag->posts();
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%$search%")
                    ->orWhere('body', 'LIKE', "%$search");
            });

        }
        $posts = $tag->posts()->latest()->paginate(12);
        return view('index', compact('posts'));
    }
}
