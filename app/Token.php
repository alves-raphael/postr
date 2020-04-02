<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['token', 'user_id', 'social_media_id', 'valid', 'token_type_id'];

    public function socialMedia(){
        return $this->belongsTo(SocialMedia::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function type(){
        return $this->belongsTo(TokenType::class);
    }

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function invalidate(){
        $this->valid = false;
        $this->save();
    }
}
