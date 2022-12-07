<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->paginate();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return RedirectResponse
     */
    public function store(StorePostRequest $request)
    {
//        $post = new Post();
//        $post->title = $request->input('title');
//        $post->body = $request->input('body');
        $post = new Post($request->validated());
        $post->user()->associate(Auth::user());
        $post->save();
        if ($request->has('images')) {
            foreach ($request->validated('images') as $file) {
                $image = new Image();
                $image->path = Storage::url($file->store('public'));
                $image->post()->associate($post);
                $image->save();
            }
        }
        return redirect()->route('posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Application|Factory|View
     */
    public function show(Post $post)
    {

        if (Auth::user() != $post->user) {
            throw new NotFoundHttpException();
        }
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Application|Factory|View
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //$post->title = $request->validated('title');
        //$post->body = $request->validated('body');
        $post->fill($request->validated());
        $post->save();
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post)
    {
        if (Auth::user() != $post->user) {
            throw new NotFoundHttpException();
        }
        $post->delete();
        return redirect()->route('posts.index');
    }
}
