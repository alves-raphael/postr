<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMediaUserId extends Model
{
    protected $fillable = ['user_id', 'social_media_id', 'value'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function socialMedia(){
        return $this->belongsTo(SocialMedia::class);
    }
}
