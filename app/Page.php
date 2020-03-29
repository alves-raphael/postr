<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function tokens(){
        return $this->hasMany(Token::class);
    }
}
