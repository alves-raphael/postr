<?php

namespace App\SocialMedia;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class SocialMedia extends Model
{
    protected $id;

    protected $fillable = ['name'];

    public const FACEBOOK = 1;

    public static function getIdBySlug() {
        
    }

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function getId(): int
    {
        return $this->id;
    }
    
}
