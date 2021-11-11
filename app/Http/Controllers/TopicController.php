<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{

    public function list()
    {
        $topics = Auth::user()->topics()->get();
        return view('topic.list', ['topics' => $topics]);
    }

    public function create(Request $request)
    {
        $request->validate(Topic::getRules());
        $topic = new Topic($request->only(['title']));
        $topic->setOrder();
        Auth::user()->topics()->save($topic);
        return redirect()->back()->with('success', 'Novo assunto cadastrado com sucesso!');
    }
}
