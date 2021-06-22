<?php

namespace App\SocialMedia;

use Laravel\Socialite\AbstractUser;
use App\Page;
use App\Token;
use App\TokenType;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Facebook extends SocialMedia
{

    protected $id = 1;

    public function __construct(Client $http)
    {
        parent::__construct();
        $this->http = $http;
    }

    public function signup(AbstractUser $user) : User
    {
       $accessToken = $this->fetchLongLivedUserAccessToken($user->token);

        $userId = (new Token())
            ->setToken($user->id)
            ->setTokenType(TokenType::USER_ID)
            ->setSocialMedia($this);

        $user = (new User())
                ->setName($user->name)
                ->setEmail($user->email);

        $user->save();
        $user->tokens()->save($accessToken);
        
        $user->tokens()->save($userId);
        $pages = $this->fetchPages($user);
        foreach($pages as $pair){
            list($token, $page) = $pair;
            $page->save();
            $user->pages()->attach($page->id);
            $page->tokens()->save($token);
        }
        return $user;
    }

    public function fetchPages(User $user): Collection
    {
        $userId = $user->getUserId($this)->token;
        $userAccess = $user->getAccessToken($this)->token;
        $url = "https://graph.facebook.com/v11.0/{$userId}/accounts?access_token={$userAccess}";

        $response = $this->http->request('GET', $url);
        $pages = json_decode($response->getBody())->data;
        return collect($pages)->map(function($page){
            $token = (new Token())
                ->setSocialMedia($this)
                ->setToken($page->access_token)
                ->setTokenType(TokenType::PAGE_ACCESS);
            $page = (new Page())
                    ->setId($page->id)
                    ->setName($page->name);
            return [$token, $page];
        });
    }

    public function fetchLongLivedUserAccessToken(string $shortLived): Token
    {
        $parameters = http_build_query([
            'grant_type'=> 'fb_exchange_token',          
            'client_id'=> getenv('FACEBOOK_CLIENT_ID'),
            'client_secret'=> getenv('FACEBOOK_CLIENT_SECRET'),
            'fb_exchange_token'=> $shortLived
        ]);
        $url = "https://graph.facebook.com/v11.0/oauth/access_token?{$parameters}";
        $response = $this->http->request('GET', $url);
        $token = json_decode($response->getBody());
        $expiration = isset($token->expires_in) ? time() + (int) $token->expires_in : null;
        return (new Token)
                    ->setToken($token->access_token)
                    ->setSocialMedia($this)
                    ->setTokenType(TokenType::USER_ACCESS)
                    ->setExpiration($expiration);
    }
}
