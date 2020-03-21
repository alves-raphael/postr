<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\SocialMedia;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Token;
use App\TokenType;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
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
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $user = new User((array) $user);
        $alreadyRegistered = User::socialMediaIds()->where('value', $user->id)->first();
        if(empty($user->created_at)){
            $user = $user->save();
            $socialMediaIds = new SocialMedisIds([
               'value' => $user->id,
               'social_media_id' => SocialMedia::FACEBOOK
               ]);
            $user->socialMediaIds()->save($socialMediaIds);
            $token = new Token([
               'token' => $user->token,
               'social_media_id' => SocialMedia::FACEBOOK,
               'token_type' => TokenType::USER
            ]);
            $user->tokens()->save($token);
        }
        Auth::login($user, true);
        return redirect()->route('dashboard');
    }
}