<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\SocialMedia;

class PostController extends Controller
{
    public function creation(){
        return view('post.create', ['socialMedias' => SocialMedia::all()]);
    }

    public function create(Request $request){
        $request->validate(Post::getRules());
        $post = new Post($request->all());
        dd($post->getAttributes());
        if(isset($post->publish)){
            $post->publish();
        }
    }
}
