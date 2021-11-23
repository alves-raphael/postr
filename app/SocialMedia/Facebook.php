<?php

namespace App\SocialMedia;

use Laravel\Socialite\AbstractUser;
use App\Page;
use App\Post;
use App\Token;
use App\TokenType;
use App\User;
use DateTime;
use Illuminate\Support\Collection;

class Facebook extends AbstractSocialMedia
{

    protected $id = 1;
    protected $http;

    public function signup(AbstractUser $user): User
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
        
        return $user;
    }

    public function fetchUserOrSignUp(AbstractUser $abstractUser): User
    {
        $user = User::where('email', $abstractUser->email)->first();
        if (empty($user)) {
            $user = $this->signup($abstractUser);
        }

        $userPagesIds = $user->pages->pluck('id');
        // Filter pages that already exists
        $pages = $this->fetchPages($user)
            ->filter(function($page) use ($userPagesIds) {
                return !$userPagesIds->contains($page[1]->id);
        });

        $this->savePages($pages, $user);

        return $user;
    }

    public function fetchPages(User $user): Collection
    {
        $userId = $user->getUserId($this)->token;
        $userAccess = $user->getAccessToken($this)->token;
        $url = "https://graph.facebook.com/v11.0/{$userId}/accounts?access_token={$userAccess}";

        $response = $this->http->request('GET', $url);
        $pages = json_decode($response->getBody())->data;
        return collect($pages)->map(function($page) use($user)
        {
            $token = (new Token())
                ->setSocialMedia($this)
                ->setToken($page->access_token)
                ->setTokenType(TokenType::PAGE_ACCESS)
                ->setUser($user)
                ;

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
        
        $expiration = null;
        if(isset($token->expires_in)){
            $expiration = time() + (int) $token->expires_in;
            $expiration = (new DateTime())->setTimestamp($expiration);
        }
        return (new Token)
                    ->setToken($token->access_token)
                    ->setSocialMedia($this)
                    ->setTokenType(TokenType::USER_ACCESS)
                    ->setExpiration($expiration);
    }

    public function publish(Post $post) : void
    {
        date_default_timezone_set('America/Bahia');
        $pageAccess = $post->fetchPageAccess();
        $body = \urlencode($post->body);
        $url = "https://graph.facebook.com/{$post->page_id}/feed?message={$body}&access_token={$pageAccess->token}";

        $response = $this->http->request('POST', $url);
        $response = json_decode($response->getBody());
        $post->id = $response->id;
        $post->published = true;
        $post->publication = new DateTime();
        $post->save();
    }

    public function savePages(Collection $pages, User $user): void
    {
        foreach($pages as $pair){
            list($token, $page) = $pair;
            if(!$page->alreadyExists()){
                $page->save();
            }
            $user->pages()->attach($page->id);
            $page->tokens()->save($token);
        }
    }
}
