<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function list(){
        $topics = Auth::user()->topics()->get();
        return view('topic.list', ['topics' => $topics]);
    }
}
