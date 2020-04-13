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

    public function publish(Request $request){
        $posts = $request->get('posts');
        $response = ['success' => false, 'messages' => [], 'result' => []];
        if(empty($posts) || !is_array($posts)){
            $response['messages'][] = "Parameter 'posts' are required and need to be a list of posts' id";
            return response()->json($response)->setStatusCode(400);
        }

        $posts = Post::whereIn('id', $posts)->get();
        $published = [];
        foreach($posts as $post){
            if($post->published){
                $published[] = $post->id;
            }
        }

        // Check if the same posts have already been published
        if(!empty($published)){
            $ids = implode(",", $published);
            $response['messages'][] = "The posts with the id {$ids} have already been published. Please try again";
            return response()->json($response)->setStatusCode(400);
        }

        foreach($posts as $post){
            $post->publish();
        }

        $response['messages'][] = 'Posts have been published with success!';
        return response()->json($response)->setStatusCode(200);
    }
}
