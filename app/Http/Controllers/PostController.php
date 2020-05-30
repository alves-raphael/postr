<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\SocialMedia\SocialMedia;
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
        Auth::user()->posts()->save($post);
        $extra = '';
        if(!$post->isScheduled()){
            $post->publish();
            $extra = 'e publicada';
        }
        return redirect()->route('post.list')->with('success', "Publicação criada {$extra} com successo");
    }

    public function list(){
        $pages = Auth::user()->pages()->get();
        $posts = [];
        foreach($pages as $page){
            $posts = array_merge($posts, $page->posts()->get()->all());
        }
        return view('post.list', ['posts' => $posts]);
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

    public function editView($id){
        $post = Post::find($id);

        if(empty($post)){
            return redirect()->back()->with('fail', 'Não foi possível efetuar a operação');
        }

        $post->socialMediaId = $post->socialMedia()->first()->id;
        $post->pageId = $post->page()->first()->id;

        $data = [
            'post' => $post,
            'socialMedias' => SocialMedia::all(),
            'pages' => Auth::user()->pages()->get(),
            'disabled' => $post->isEditable() ? '' : 'disabled'
        ];

        return view('post.edit', $data);
    }

    public function edit(int $id, Request $request){
        $post = Auth::user()->posts()->find($id);

        if(empty($post) || !$post->isEditable()){
            return redirect()->back()->with('fail', 'Essa publicação já não pode mais ser editada');
        }
        $post->update($request->all());
        return redirect()->route('post.list')->with('success', 'Publicação foi editada com sucesso!');
    }
}
