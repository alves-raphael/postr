<?php

namespace App\SocialMedia;

use App\User;
use App\Post;

abstract class AbstractSocialMedia extends SocialMedia {
    /**
     * Create and return a new user based on given data or retrieve
     * from database if already exists
     * @param any $abstractUser
     * @return User
     */
    abstract function signUser($abstractUser) : User;

    // abstract function publish(Post $post, $client);
}