<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{

    public function list()
    {
        $pending = Auth::user()->topics()->where('status', Topic::PENDING)->get();
        $progress = Auth::user()->topics()->where('status', Topic::PROGRESS)->first();
        $done = Auth::user()->topics()->where('status', Topic::DONE)->get();
        return view('topic.list', ['pending' => $pending, 'progress' => $progress, 'done' => $done ]);
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
