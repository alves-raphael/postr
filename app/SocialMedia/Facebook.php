<?php

namespace App\SocialMedia;

use App\User;
use App\SocialMedia\Facebook;

class Facebook extends SocialMedia {

    protected $id = 1;

    //TODO
    public function createUser($data) : User {
        $accessToken = (new Token([
            'token' => $data->token,
            'token_type_id' => TokenType::USER_ACCESS
        ]))->setSocialMedia(new Facebook());

        $user = new User();
        return $user;
    }
}