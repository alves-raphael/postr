<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\Eloquent\Builder;
use App\SocialMedia\Facebook;
use Illuminate\Support\Str;

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

    public $justCreated;

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
        return $this->belongsToMany(Page::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function setupPages($client = null){
        $userId = $this->getLastValidToken(TokenType::USER_ID)->token;
        $userAccessToken = $this->getLastValidToken(TokenType::USER_ACCESS)->token;
        $url = "https://graph.facebook.com/{$userId}/accounts?access_token={$userAccessToken}";
        $client = $client ? : new \GuzzleHttp\Client();
        $response = null;
        
        $response = $client->request('GET', $url);
        $response = json_decode($response->getBody())->data;
        foreach($response as $item){
            $page = Page::firstOrCreate([
                'name' => $item->name,
                'social_media_token' => $item->id
            ]);
            
            $this->pages()->attach($page->id);

            $token = (new Token([
                'token' => $item->access_token,
                'token_type_id' => TokenType::PAGE_ACCESS,
                'user_id' => $this->id
            ]))->setSocialMedia(new Facebook());
            
            $page->tokens()->save($token);
        }
        
    }

    public static function createRandom(){
        $rand = rand(0,999);
        $user = \App\User::create([
            'name' => 'testuser' . $rand,
            'email' => "test{$rand}@gmail.com",
        ]);

        $userAccessToken = new Token([
            'token' => Str::random(40),
            'token_type_id' => TokenType::USER_ACCESS,
        ]);
        $userAccessToken->setSocialMedia(new Facebook());
        $user->tokens()->save($userAccessToken);

        $userId = new Token([
            'token' => Str::random(40),
            'token_type_id' => TokenType::USER_ID,
        ]);

        $userId->setSocialMedia(new Facebook());
        $user->tokens()->save($userId);
        return $user;
    }

    public function getUserId(){
        return $this->tokens()->where('token_type_id', TokenType::USER_ID)->first();
    }
}
