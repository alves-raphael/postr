<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['social_media_token', 'name','user_id'];

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function alreadyExist(){
        return $this->where('social_media_token', $this->social_media_token)->first();
    }
}
