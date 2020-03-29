<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

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
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    public function tokens(){
        return $this->hasMany(Token::class);
    }
    
    public function getLastValidToken($type) {
        return $this->tokens()->where('valid', true)->where('token_type_id', $type)->orderBy('created_at')->first();
    }

    public function isAlreadyRegistered($facebookUserId){
        return User::with(['tokens' => 
            function ($query) use($facebookUserId) {
                $query->where('token', $facebookUserId)
                ->where('token_type_id', TokenType::USER_ID);
            }])->first();
    }

    public function signUp($token, $faceId){
        DB::beginTransaction();
        try{
            $this->save();
            $token = new Token([
                'token' => $token,
                'social_media_id' => SocialMedia::FACEBOOK,
                'token_type_id' => TokenType::USER
            ]);
            $this->tokens()->save($token);
            $token = new Token([
                'token' => $faceId,
                'social_media_id' => SocialMedia::FACEBOOK,
                'token_type_id' => TokenType::USER_ID
            ]);
            $this->tokens()->save($token);
            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function getUserId(){
        $this->tokens()->where('token_type_id', TokenType::USER_ID)->first();
    }
}
