<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Mockery;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\AbstractUser;
use App\TokenType;
use App\SocialMedia\Facebook;

class FacebookTest extends TestCase
{
    use RefreshDatabase;

    public function testSignUser(){
        $this->seed();
        $this->seed(\UsersTestSeeder::class);
        $user = User::where('email','raphael@gmail.com')->first();
        $fakeData = json_decode('{"token":"12132432423412312312","refreshToken":null,"expiresIn":null,"id":"324984894894984","nickname":null,"name":"Jonisclyason da Silva","email":"jonisclayson.pinto@outlook.com","avatar":"https://graph.facebook.com/v3.3/1799407560165917/picture?type=normal","avatar_original":"https://graph.facebook.com/v3.3/1799407560165917/picture?width=1920","profileUrl":null}');
        $fakeUser = new \StdClass();
        $fakeUser->token = $fakeData->token;
        $fakeUser->id = $fakeData->id;
        $fakeUser->name = $fakeData->name;
        $fakeUser->email = $fakeData->email;
        $facebook = new Facebook();
        $fakeUser = $facebook->signUser($fakeUser);
        
        $this->assertTrue($fakeUser instanceof User);
        $this->assertEquals($fakeUser->tokens()->where('token_type_id', TokenType::USER_ID)->first()->token, "324984894894984");
        $this->assertTrue(!empty(User::where('email', 'jonisclayson.pinto@outlook.com')->first()));
    }
}
