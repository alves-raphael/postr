<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Topic extends Model
{
    protected $fillable = ['title'];

    const PENDING = 0;
    const PROGRESS = 1;
    const DONE = 2;

    public function posts()
    {
        return $this->hasMany(Topic::class);
    }

    
    public static function getRules(): array
    {
        return [
            'title' => 'required|min:3'
        ];
    }

    /**
     * Get the greatest order_id by user,
     * adds +1 and set to this object
     * @return void
     */
    public function setOrder(): void
    {
        $topic = Auth::user()->topics()->orderByDesc('order')->first();
        $this->order = empty($topic) ? 1 : $topic->order + 1;
    }

    public function getStatusDescription(): string
    {
        $descriptions = ['Pendente', 'Em progresso', 'Finalizado'];
        if($this->status > count($descriptions) - 1) {
            return '';
        }
        return $descriptions[$this->status];
    }
}
