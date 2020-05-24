<?php

namespace App\Network;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    private $request;

    private function setRequest($request){
        $this->request = $request;
        return $this;
    }
}
