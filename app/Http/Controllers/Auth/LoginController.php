<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocialMedia\AbstractSocialMedia;
use App\SocialMedia\SocialMedia;
use Laravel\Socialite\AbstractUser;
use Illuminate\Support\Facades\Auth;
use App\SocialMedia\Facebook;
use App\User;
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
        return Socialite::driver('facebook')
            ->scopes(['pages_manage_posts', 'pages_read_engagement'])->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback(Facebook $facebook)
    {
        $user = Socialite::driver('facebook')->user();
        return $this->signUpAndLogin($facebook, $user);
    }

    private function signUpAndLogin(AbstractSocialMedia $socialMedia, AbstractUser $abstract)
    {
        $user = $socialMedia->fetchUserOrSignUp($abstract);
        Auth::login($user);
        return redirect()->route('post.list');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
