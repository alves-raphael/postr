<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SocialMedia\SocialMedia;
use Guzzle\HttpGuzzle;
use DateTime;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'publication', 'published','social_media_token', 'social_media_id','page_id'];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dates = ['publication', 'created_at','updated_at'];

    private $socialMedia;
    private $user;
    private $page;

    public function setPage(Page $page){
        $this->page = $page;
        $this->page_id = $page->id;
        return $this;
    }

    public function setUser(User $user){
        $this->user = $user;
        $this->user_id = $user->id;
        return $this;
    }

    public function setSocialMedia(SocialMedia $socialMedia){
        $this->socialMedia = $socialMedia;
        $this->social_media_id = $socialMedia->getId();
        return $this;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function socialMedia(){
        return $this->belongsTo(SocialMedia::class);
    }

    public static function getRules(){
        return [
            'title' => 'required|min:3',
            'body' => 'required',
            'publication' => [
                function($attr, $date, $fail){
                    $date = new DateTime($date);
                    $now = (new DateTime())->add(new \DateInterval('PT5M')); // now + 5min
                    if($date < $now){
                        return $fail('Data de publicação precisa ter 5 minutos de antecedência.');
                    }
                }
            ]
        ];
    }

    public function isScheduled(){
        return !empty($this->publication);
    }

    /**
     * Publish post in social media
     */
    public function publish($client = null){
        $page = $this->page()->first();
        $pageAccessToken = $page->tokens()->where('valid', true)->first()->token;
        $body = \urlencode($this->body);
        $url = "https://graph.facebook.com/{$page->social_media_token}/feed?message={$body}&access_token={$pageAccessToken}";
        $client = $client ? : new \GuzzleHttp\Client();
        
        $response = $client->request('POST', $url);
        $response = json_decode($response->getBody());
        $this->social_media_token = $response->id;
        $this->published = true;
        $this->save();
        
    }

    public function isEditable() : bool 
    {
        $fiveMinFromNow = (new DateTime())->add(new \DateInterval('PT5M'));
        return $fiveMinFromNow <= $this->publication;
    }
}