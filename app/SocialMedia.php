<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    const FACEBOOK = 1;
    const TWITTER = 2;


    protected $fillable = ['name'];

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function socialMediaUserIds(){
        return $this->hasMany(SocialMediaUserIds::class);
    }
}
