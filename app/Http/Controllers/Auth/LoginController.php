<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocialMedia\SocialMedia;
use Laravel\Socialite\AbstractUser;
use Illuminate\Support\Facades\Auth;
use App\SocialMedia\Facebook;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        return $this->login(new Facebook(), $user);
    }

    private function login(SocialMedia $socialMedia, AbstractUser $user){
        $user = $socialMedia->assing($user);
        Auth::login($user);
        return redirect()->route('post.list');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
