<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['social_media_token', 'name','user_id'];
    private $user;

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function setUser(User $user) : Page
    {
        $this->user = $user;
        $this->user_id = $user->id;
        return $this;
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function alreadyExist() : boolean 
    {
        return !empty($this->where('social_media_token', $this->social_media_token)->first());
    }

    public function setup(){

    }
}
