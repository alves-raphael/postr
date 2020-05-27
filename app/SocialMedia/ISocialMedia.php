<?php

namespace App\SocialMedia;

use App\User;

interface ISocialMedial {
    /**
     * Create and return a new user based on given data or retrieve
     * from database if already exists
     * @param any $abstractUser
     * @return User
     */
    function signUser($abstractUser) : User;
}