<?php

namespace App\SocialMedia;

use App\Token;
use App\TokenType;
use App\User;
use Laravel\Socialite\AbstractUser;

class Facebook extends AbstractSocialMedia {

    protected $id = 1;

    public function signUser($abstractUser) : User {
        $accessToken = (new Token([
            'token' => $abstractUser->token,
            'token_type_id' => TokenType::USER_ACCESS
        ]))->setSocialMedia(new Facebook());

        $userId = (new Token([
            'token' => $abstractUser->id,
            'token_type_id' => TokenType::USER_ID
        ]))->setSocialMedia(new Facebook());
         
        $user = User::firstOrNew([
                'name' => $abstractUser->name,
                'email' => $abstractUser->email
            ]);
        $user->justCreated = !$user->exists;
        $user->save();
        $user->tokens()->save($accessToken);
        if($user->justCreated){
            $user->tokens()->save($userId);
        }
        return $user;
    }

}
