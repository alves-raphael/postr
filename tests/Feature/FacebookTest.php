<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Token;
use App\SocialMedia\SocialMedia;
use App\Page;
use Mockery;
use Illuminate\Support\Facades\Auth;

class FacebookTest extends TestCase
{
    use RefreshDatabase;

    public function testSingUser(){
        $this->seed();
        $this->seed(\UsersTestSeeder::class);

        $user = User::where('email','raphael@gmail.com')->first();
    }
}
