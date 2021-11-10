<?php

namespace App;

use App\SocialMedia\SocialMedia;
use Carbon\Carbon;
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
        'name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token'
    ];

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function getAccessToken(SocialMedia $socialMedia)
    {
        return $this->tokens()->where('token_type_id', TokenType::USER_ACCESS)
                ->where(function($query){
                    $query->where('expiration', '>=' , time())
                    ->orWhere('expiration', null);
                })
                ->where('social_media_id', $socialMedia->getId())
                ->orderBy('created_at')->first();
    }

    public function getUserId(SocialMedia $socialMedia): Token
    {
        return $this->tokens()->where('token_type_id', TokenType::USER_ID)
                ->where('social_media_id', $socialMedia->getId())->first();
    }

    public function pages(){
        return $this->belongsToMany(Page::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

}
