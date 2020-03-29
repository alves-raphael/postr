<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Guzzle\HttpGuzzle;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'publication', 'published','social_media_token', 'social_media_id'];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dates = ['publication', 'created_at','updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
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

    public function publish(){
        $this->published = true;
    }
}
