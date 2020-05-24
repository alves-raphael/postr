<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\SocialMedia\SocialMedia;
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
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('facebook')->user();
        $facebookUserId = $user->id;

        $userAccessToken = (new Token([
            'token' => $user->token,
            'token_type_id' => TokenType::USER_ACCESS
        ]))->setSocialMedia(new Facebook());

        $user = new User((array) $user);
        $alreadyRegistered = $user->isAlreadyRegistered($facebookUserId);
        if(!$alreadyRegistered){ // Not registered yet
            $user->signUp($facebookUserId);
            $user->tokens()->save($userAccessToken);
            $user->setupPages();
        }else{
            $user = $alreadyRegistered;
            $user->tokens()->save($userAccessToken);
        }
        Auth::login($user, true);
        return redirect()->route('post.list');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}