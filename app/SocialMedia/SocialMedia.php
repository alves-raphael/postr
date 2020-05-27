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
}
