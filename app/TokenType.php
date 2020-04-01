<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenType extends Model
{
    const USER_ACCESS = 1;
    const PAGE_ACCESS = 2;
    const APP = 3;
    const USER_ID = 4;
    const PAGE_ID = 5;
    
    protected $fillable = ['name'];

    public function tokens(){
        return $this->hasMany(Token::class);
    }
}
