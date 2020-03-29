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

    public function invalidate(){
        $this->valid = false;
        $this->save();
    }

    public function getNewPageAccessToken(){
        $userId = Auth::user()->getUserId()->token;
        $userAccessToken = Auth::user()->getLastValidToken(TokenType::USER);
        $url = "https://graph.facebook.com/{$userId}/accounts?access_token={$userAccessToken}";
        $client = new GuzzleHttp\Client();
        $response = null;
        try {
            $response = $client->get($url);
        } catch(\Exception $e){
            die($e->getMessage());
        }
    }
}
