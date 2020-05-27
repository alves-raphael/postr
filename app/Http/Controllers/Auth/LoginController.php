<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocialMedia\SocialMedia;
use App\User;
use Laravel\Socialite\AbstractUser;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Token;
use App\TokenType;
use App\SocialMedia\Facebook;

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
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        return $this->login(new Facebook(), $user);
    }

    private function login(SocialMedia $socialMedia, AbstractUser $user){
        $user = $socialMedia->signUser($user);
        Auth::login($user);
        $route = $user->justCreated ? 'page.create' : 'post.list';
        return redirect()->route($route);
        
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
