<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSocialMediaUser(int $socialMediaId) : bool {
        return !$this->socialMediaUserIds()
            ->where("social_media_id", $socialMediaId)->isEmpty();
    }

    public function socialMediaUserIds(){
        return $this->hasMany(SocialMediaUserId::class);
    }

    public function tokens(){
        return $this->hasMany(Token::class);
    }
    
    public function getLastValidToken() : Token {
        return $this->tokens()->where('valid', true)->order('created_at')->first();
    }
}
