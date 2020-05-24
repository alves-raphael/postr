<?php

namespace App\SocialMedia;

use Illuminate\Database\Eloquent\Model;
use App\User;

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

    abstract public function createUser($data) : User;
}
