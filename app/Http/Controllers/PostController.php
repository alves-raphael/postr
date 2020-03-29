<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\SocialMedia;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function creation(){
        return view('post.create', ['socialMedias' => SocialMedia::all()]);
    }

    public function create(Request $request){
        $request->validate(Post::getRules());
        $post = new Post($request->all());
        $post->user()->associate(Auth::user());
        if(!$post->publication){
            $post->publish();
        }
        $post->save();
        return redirect()->back()->with('success', 'Publicação criada com successo');
    }
}
