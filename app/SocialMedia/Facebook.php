<?php

namespace App\SocialMedia;

use Laravel\Socialite\AbstractUser;
use App\Page;
use App\Token;
use App\TokenType;
use App\User;

class Facebook extends SocialMedia
{

    protected $id = 1;

    public function assing(AbstractUser $user) : User
    {
        $accessToken = (new Token())
            ->setToken($user->token)
            ->setTokenType(TokenType::USER_ACCESS)
            ->setExpiration($user->expiresIn)
            ->setSocialMedia(new Facebook());

        $userId = (new Token())
            ->setToken($user->id)
            ->setTokenType(TokenType::USER_ID)
            ->setSocialMedia(new Facebook());

        $user = User::firstOrNew([
                'name' => $user->name,
                'email' => $user->email
            ]);
        $user->justCreated = !$user->exists;
        $user->save();
        $user->tokens()->save($accessToken);
        if($user->justCreated){
            $user->tokens()->save($userId);
            // $this->setupPages($userId, $accessToken);
        }
        return $user;
    }

    public function getPage(): array
    {
        return [];
    }

    public function setupPages(Token $userId, Token $userAccess)
    {
        $url = "https://graph.facebook.com/{$userId}/accounts?access_token={$userAccess}";
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $url);
        $response = json_decode($response->getBody())->data;
        foreach($response as $item){
            $page = Page::firstOrCreate([
                'name' => $item->name,
                'social_media_token' => $item->id
            ]);
            
            $this->pages()->attach($page->id);

            $token = (new Token([
                'token' => $item->access_token,
                'token_type_id' => TokenType::PAGE_ACCESS,
                'user_id' => $this->id
            ]))->setSocialMedia(new Facebook());
            
            $page->tokens()->save($token);
        }
    }
}
