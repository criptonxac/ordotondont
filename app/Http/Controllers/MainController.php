<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Post;
use App\Services\TelegramBot;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::all();
        return view('content.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function contact(ContactRequest $request)
    {
        if ($request->isMethod('GET')){

            return view('content.contact');
        }
        $bot=new TelegramBot('6387450713:AAHp03Sm2qk_3brQieYL-rmW254-slA7WiY');
        $text="Ismi: {$request->name}
Kontakt: {$request->number}
Mavzu:  {$request->mavzu}
Habar: {$request->xabar}" ;
        $bot->sendMessage(377431121,$text);
        return back();

    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
