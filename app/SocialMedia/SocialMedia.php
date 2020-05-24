<?php

namespace App\SocialMedia;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Laravel\Socialite\AbstractUser;

abstract class SocialMedia extends Model
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
     * @param AbstractUser $abstractUser
     * @return User
     */
    abstract public function signUser(AbstractUser $abstractUser) : User;
}
