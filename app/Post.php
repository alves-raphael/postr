<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Guzzle\HttpGuzzle;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'publication', 'published','social_media_token', 'social_media_id','page_id'];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dates = ['publication', 'created_at','updated_at'];

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
                    $date = new \DateTime($date);
                    $now = new \DateTime();
                    if($date < $now){
                        return $fail('Data de publicação não pode ser inferior a data de hoje.');
                    }
                }
            ]
        ];
    }

    public function isScheduled(){
        return !empty($this->publication);
    }
    public function publish($client = null){
        $page = $this->page()->first();
        $pageAccessToken = $page->tokens()->where('valid', true)->first()->token;
        $body = \urlencode($this->body);
        $url = "https://graph.facebook.com/{$page->social_media_token}/feed?message={$body}&access_token={$pageAccessToken}";
        $client = $client ? : new \GuzzleHttp\Client();
        try{
            $response = $client->request('POST', $url);
            $response = json_decode($response->getBody());
            $this->social_media_token = $response->id;
            $this->published = true;
            $this->save();
        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}