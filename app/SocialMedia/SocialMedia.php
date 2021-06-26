<?php

namespace App\SocialMedia;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use App\User;
use GuzzleHttp\Client;
use Laravel\Socialite\AbstractUser;

abstract class SocialMedia extends Model
{
    protected $id;

    protected $fillable = ['name'];

    protected $http;

    public function __construct(Client $http)
    {
        parent::__construct();
        $this->http = $http;
    }

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function getId() : int {
        return $this->id;
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
    // abstract function publish(Post $post, Page $page) : void;
    
}
