<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'publish', 'posted','social_media_token', 'social_media_id'];

    protected $casts = [
        'posted' => 'boolean'
    ];

    protected $dates = ['publish', 'created_at','updated_at'];

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
            'publish' => [
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
        $this->posted = true;
    }
}
