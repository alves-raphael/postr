<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\SocialMedia\SocialMedia;
use App\SocialMedia\AbstractSocialMedia;
use App\SocialMedia\Twitter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function creation(){
        $pages = Auth::user()->pages()->get();
        return view('post.create', ['socialMedias' => SocialMedia::all(), 'pages' => $pages]);
    }

    public function create(Request $request, AbstractSocialMedia $socialMedia){
        $request->validate(Post::getRules());
        $post = new Post($request->all());
        Auth::user()->posts()->save($post);
        $extra = '';
        if(!$post->isScheduled()){
            $socialMedia->publish($post);
            $extra = 'e publicada ';
        }
        return redirect()->route('post.list')->with('success', "Publicação criada {$extra}com successo");
    }

    public function list(Request $request){
        $pages = Auth::user()->pages->pluck('id');    
        $posts = Post::whereIn('page_id', $pages)->orderBy('created_at', 'desc');
        $socialMedias = SocialMedia::all();
        $filters = $request->only(['start','end', 'socialMedia']);
        if(!empty($filters)) {
            $posts = $this->filter($posts, $filters);
        }
        return view('post.list', ['posts' => $posts->get(), 'socialMedias' => $socialMedias]);
    }

    public function publish(Request $request, AbstractSocialMedia $socialMedia){
        $response = ['success' => false, 'messages' => [], 'result' => []];

        $posts = $request->get('posts');
        if(empty($posts) || !is_array($posts)){
            $response['messages'][] = "Parameter 'posts' is required and need to be a list of posts' id";
            return response()->json($response)->setStatusCode(400);
        }

        $posts = Post::whereIn('id', $posts)->get();
        if($posts->isEmpty()){
            $response['messages'][] = "Invalid posts id";
            return response()->json($response)->setStatusCode(400);
        }

        $published = $posts->filter(function($post){
            return $post->published;
        })->pluck('id');

        // Check if the same posts have already been published
        if($published->isNotEmpty()){
            $ids =  $published->join(', ');
            $response['messages'][] = "The posts with the id {$ids} have already been published.";
            return response()->json($response)->setStatusCode(400);
        }

        foreach($posts as $post){
            $socialMedia->publish($post);
        }

        $response['messages'][] = 'Posts have been published with success!';
        $response['success'] = true;
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

    public function edit(string $id, Request $request){
        $post = Auth::user()->posts()->find($id);

        if(empty($post) || !$post->isEditable()){
            return redirect()->back()->with('fail', 'Essa publicação já não pode mais ser editada');
        }
        $post->update($request->all());
        return redirect()->route('post.list')->with('success', 'Publicação foi editada com sucesso!');
    }

    public function filter($posts, array $filter)
    {
        if(!empty($filter['start'])){
            $posts = $posts->whereDate('publication', '>=', $filter['start']);
        } if(!empty($filter['end'])){
            $posts = $posts->whereDate('publication', '<=', $filter['end']);
        } if(!empty($filter['socialMedia'])){
            $posts = $posts->where('social_media_id', $filter['socialMedia']);
        }
        return $posts;
    }
}
