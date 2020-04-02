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
        $pages = Auth::user()->pages()->get();
        return view('post.create', ['socialMedias' => SocialMedia::all(), 'pages' => $pages]);
    }

    public function create(Request $request){
        $request->validate(Post::getRules());
        $post = new Post($request->all());
        $post->save();
        $extra = '';
        if(!$post->isScheduled()){
            $post->publish();
            $extra = 'e publicada';
        }
        return redirect()->back()->with('success', "Publicação criada {$extra} com successo");
    }
}
