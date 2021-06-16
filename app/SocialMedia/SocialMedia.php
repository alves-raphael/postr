<?php

namespace App\SocialMedia;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Laravel\Socialite\AbstractUser;

class SocialMedia extends Model
{
    protected $id;

    protected $fillable = ['name'];

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function getId() : int {
        return $this->id;
    }

    /**
     * Create and return a new user based on given data or retrieve
     * from database if already exists
     * @param any $abstractUser
     * @return User
     */
    // abstract function signUser($abstractUser) : User;

    // /**
    //  * Logic behind social media specific integration to publish a post
    //  * @param Post $post - post to be sent
    //  */
    // abstract function send(Post $post, $client) : void;
    
}
