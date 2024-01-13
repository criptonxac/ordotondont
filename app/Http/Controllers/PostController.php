<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function about()
    {
        $posts = Post::all();
        return view('post.about',compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
            $path = $request->file('photo')->store('uplouds');



       $post = Post::create([

           'title'          =>$request->title,
           'short_content'  =>$request->short_content,
           'photo'          =>$path  ?? null,

       ]);

       return to_route('create');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('show',compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        if (isset($post->photo)){
            Storage::delete($post->photo);
        }
        $path = $request->file('photo')->store('uplouds');


        $post->update([

            'title'          =>$request->title,
            'short_content'  =>$request->short_content,
            'photo'          =>$path  ?? $post->photo,

        ]);

        return redirect()->route('about',['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
