<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['name','user_id'];
    private $user;
    public $incrementing = false;

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function setUser(User $user) : Page
    {
        $this->user = $user;
        $this->user_id = $user->id;
        return $this;
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function alreadyExists() : bool
    {
        return !empty($this->find($this->id));
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
