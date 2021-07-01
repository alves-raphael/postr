<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SocialMedia\SocialMedia;
use DateTime;

class Token extends Model
{
    protected $fillable = ['token', 'user_id', 'social_media_id', 'expiration', 'token_type_id', 'page_id'];

    protected $guarded = ['page', 'user'];

    /**
     * @var App\SocialMedia
     */
    private $socialMedia;

    /**
     * @var App\Page
     */
    private $page;

    /**
     * @var App\User
     */
    private $user;

    public function setSocialMedia(SocialMedia $socialMedia){
        $this->socialMedia = $socialMedia;
        $this->social_media_id = $socialMedia->getId();
        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function setTokenType(int $type): self
    {
        $this->token_type_id = $type;
        return $this;
    }

    public function setPage(Page $page){
        $this->page = $page;
        $this->page_id = $page->id;
        return $this;
    }

    public function setExpiration(?DateTime $expiration): self
    {
        $this->expiration = $expiration;
        return $this;
    }

    public function socialMedia(){
        return $this->belongsTo(SocialMedia::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function type(){
        return $this->belongsTo(TokenType::class);
    }

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function setSocialMediaId(int $id): self
    {
        $this->social_media_id = $id;
        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        $this->user_id = $user->id;
        return $this;
    }

    public function getPageAccess(Page $page, User $user): Token
    {
        return $this->where('token_type_id', TokenType::PAGE_ACCESS)
                ->where('expiration', '<=' , time())
                ->orWhere('expiration', null)
                ->where('social_media_id', 1)
                ->where('page_id', $page->id)
                ->where('user_id', $user->id)
                ->orderBy('created_at')->first();
    }
}
