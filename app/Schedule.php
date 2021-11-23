<?php

namespace App;

use App\SocialMedia\SocialMedia;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    private const WEEK_DAYS = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];

    public static function getWeekDays(): array
    {
        return self::WEEK_DAYS;
    }

    protected $fillable = ['weekday', 'social_media_id', 'user_id', 'time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function socialMedia()
    {
        return $this->belongsTo(SocialMedia::class);
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->user_id = $user->id;
        return $this;
    }

    public function setSocialMedia(SocialMedia $socialMedia)
    {
        $this->socialMedia = $socialMedia;
        $this->social_media_id = $socialMedia->getId();
        return $this;
    }
}
