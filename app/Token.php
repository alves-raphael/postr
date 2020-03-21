<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public function socialMedia(){
        return $this->belongsTo(SocialMedia::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function type(){
        return $this->belongsTo(TokenType::class);
    }
}
