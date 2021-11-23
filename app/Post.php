<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SocialMedia\SocialMedia;
use Illuminate\Support\Carbon;
use DateTime;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'publication', 'published','social_media_token', 'social_media_id','page_id', 'topic_id'];
    public $incrementing = false;

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $guarded = ['page'];

    protected $dates = ['publication', 'created_at','updated_at'];

    private $socialMedia;
    private $user;

    public function setPage(Page $page)
    {
        $this->page = $page;
        $this->page_id = $page->id;
        return $this;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function socialMedia()
    {
        return $this->belongsTo(SocialMedia::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public static function getRules()
    {
        return [
            'title' => 'required|min:3',
            'body' => 'required',
            'publication' => [
                function($attr, $date, $fail)
                {
                    $date = new DateTime($date);
                    $now = (new DateTime())->add(new \DateInterval('PT5M')); // now + 5min
                    if($date < $now)
                    {
                        return $fail('Data de publicação precisa ter 5 minutos de antecedência.');
                    }
                }
            ]
        ];
    }

    public function isScheduled(): bool
    {
        return !empty($this->publication);
    }

    public function isEditable() : bool 
    {
        $fiveMinFromNow = new Carbon((new DateTime())->add(new \DateInterval('PT5M')));
        return $fiveMinFromNow->lessThanOrEqualTo($this->publication);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }


    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            if(empty($model->id)){
                $model->id = uniqid();
            }
        });
    }

    public function fetchPageAccess(): Token
    {
        return Token::where('token_type_id', TokenType::PAGE_ACCESS)
                ->where('social_media_id', 1)
                ->where('page_id', $this->page_id)
                ->where('user_id', $this->user_id)
                ->where(function($query){
                    $query->where('expiration', '>=' , time())
                    ->orWhere('expiration', null);
                })->orderBy('created_at')->first();
    }
}