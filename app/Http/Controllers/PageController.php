<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function createMany(){
        $user = Auth::user();
        $user->setupPages();
        return redirect()->route('post.list');
    }
}
