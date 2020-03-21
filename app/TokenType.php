<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenType extends Model
{
    const USER = 1;
    const PAGE = 2;
    const APP = 3;
    
    protected $fillable = ['name'];

    public function tokens(){
        return $this->hasMany(Token::class);
    }
}
