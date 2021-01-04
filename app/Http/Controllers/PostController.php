<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Post;
use \App\User;


class PostController extends Controller
{
        public function index()
    {
        // $posts = Post::latest()->gets();
        return view('home', [
            'posts' => auth()->user()->timeline()
        ]);
        // dd($posts);
    }

    public function store()
    {
        $attributes = request()->validate(['body' => 'required|max:500']);

        Post::create([
            'user_id' => auth()->id(),
            'body' => $attributes['body']
        ]);
        return redirect('/home');
    }
}
