<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\Eloquent\Builder;

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

    public function getLastValidToken($type) {
        return $this->tokens()->where('valid', true)->where('token_type_id', $type)->orderBy('created_at')->first();
    }

    public function pages(){
        return $this->hasMany(Page::class);
    }

    public function isAlreadyRegistered($facebookUserId){
        return \App\User::whereHas('tokens',
            function (Builder $query) use($facebookUserId) {
                $query->where('token', $facebookUserId);
            }
        )->first();
    }

    public function setupPages($client = null){
        $userId = $this->getLastValidToken(TokenType::USER_ID)->token;
        $userAccessToken = $this->getLastValidToken(TokenType::USER_ACCESS)->token;
        $url = "https://graph.facebook.com/{$userId}/accounts?access_token={$userAccessToken}";
        $client = $client ? : new \GuzzleHttp\Client();
        $response = null;
        try {
            $response = $client->request('GET', $url);
            $response = json_decode($response->getBody())->data;
            foreach($response as $item){
                $page = new Page([
                    'name' => $item->name,
                    'social_media_token' => $item->id
                ]);

                $page = $page->getFetchedOrItself();
                $this->pages()->save($page);

                $token = new Token([
                    'token' => $item->access_token,
                    'social_media_id' => SocialMedia::FACEBOOK,
                    'token_type_id' => TokenType::PAGE_ACCESS,
                    'user_id' => $this->id
                ]);
                $page->tokens()->save($token);
            }
        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function signUp($faceId){
        DB::beginTransaction();
        try{
            $this->save();
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
        return $this->tokens()->where('token_type_id', TokenType::USER_ID)->first();
    }
}
