<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\SocialMedia;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')
            ->scopes(['manage_pages', 'publish_pages'])
            ->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('facebook')->user();
        $facebookUserId = $user->id;
        $token = $user->token;
        $user = new User((array) $user);
        $alreadyRegistered = $user->isAlreadyRegistered($facebookUserId);
        if(!$alreadyRegistered){ // Not registered yet
            $user->signUp($token, $facebookUserId);
            $user->setupPages();
        }else{
            $user = $alreadyRegistered;
        }
        Auth::login($user, true);
        return redirect()->route('post.list');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}