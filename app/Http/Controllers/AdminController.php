<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
//
//    public function listRoutes()
//    {
//        $routes = Route:: getRoutes();
//        $data = [
//            'routes'=>$routes,
//        ];
//        return view('auth.login');
//    }

    public function dashbord()
    {
        return view('admin.dashbord');
    }


    public function home()
    {
        return view('admin.home');
    }

    public function newslist(){

        $posts=Post::query()->paginate();

        return view('admin.newslist',compact('posts'));
    }

    public function edit(Post $post){

        return view('admin.edit',compact('post'));
    }

    public function delete(Post $post)
    {
        $post->delete();

        return back();
    }

}
