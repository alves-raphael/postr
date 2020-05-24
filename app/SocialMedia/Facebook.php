<?php

namespace App\SocialMedia;

use App\Token;
use App\TokenType;
use App\User;
use Laravel\Socialite\AbstractUser;

class Facebook extends SocialMedia {

    protected $id = 1;

    //TODO
    public function signUser(AbstractUser $abstractUser) : User {
        $accessToken = (new Token([
            'token' => $abstractUser->token,
            'token_type_id' => TokenType::USER_ACCESS
        ]))->setSocialMedia(new Facebook());

        $userId = (new Token([
            'token' => $abstractUser->id,
            'token_type_id' => TokenType::USER_ID
        ]))->setSocialMedia(new Facebook());

        $user = User::firstOrNew((array) $abstractUser);
        $didntExist = !$user->exists;
        $user->save();
        if($didntExist){
            $user->setupPages();
        }
        return $user;
    }
}
