<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\SocialMedia;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Token;
use App\TokenType;
use Illuminate\Support\Facades\DB;

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
        $facebookUserId = $user->id;
        $token = $user->token;
        $user = new User((array) $user);
        $alreadyRegistered = User::with(['socialMediaUserIds' => 
            function($query) use($user, $facebookUserId) {
                $query->where('value', $facebookUserId);
            }])->first();
        if(!$alreadyRegistered){ // Not registered yet
            $this->singIn($user, $token, $facebookUserId);
        }
        Auth::login($user, true);
        return redirect()->route('dashboard');
    }

    private function signIn($user, $token, $faceId){
        DB::beginTransaction();
        try{
            $user->save();
            $socialMediaIds = new \App\SocialMediaUserId([
                'value' => $faceId,
                'social_media_id' => SocialMedia::FACEBOOK
            ]);
            $user->socialMediaUserIds()->save($socialMediaIds);
            $token = new Token([
                'token' => $token,
                'social_media_id' => SocialMedia::FACEBOOK,
                'token_type_id' => TokenType::USER
            ]);
            $user->tokens()->save($token);
            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}