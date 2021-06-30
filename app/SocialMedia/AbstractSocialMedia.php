<?php

namespace App\SocialMedia;

use App\Post;
use App\User;
use GuzzleHttp\Client;
use Laravel\Socialite\AbstractUser;

abstract class AbstractSocialMedia extends SocialMedia
{
    protected $http;

    public function __construct(Client $http)
    {
        parent::__construct();
        $this->http = $http;
    }
    
    /**
     * Create and return a new user based on given data
     * @param AbstractUser $abstractUser
     * @return User
     */
    abstract function signup(AbstractUser $abstractUser) : User;

    /**
     * Logic behind social media specific integration to publish a post
     * @param Post $post - post to be sent
     */
    abstract function publish(Post $post) : void;
}