<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Token;
use App\SocialMedia;
use App\Page;
use Mockery;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSetupPages()
    {
        $this->seed();

        $user = User::create([
            'name' => 'Raphael',
            'email' => 'raphael@gmail.com',
        ]);

        $userAccessToken = Token::create([
            'token' => 'asdaskljcnaqqn11980bn98b127xn12987x141739xnz12*&&)(*)',
            'user_id' => $user->id,
            'social_media_id' => SocialMedia::FACEBOOK,
            'token_type_id' => \App\TokenType::USER_ACCESS,
        ]);

        $userAccessToken = Token::create([
            'token' => '123456789',
            'user_id' => $user->id,
            'social_media_id' => SocialMedia::FACEBOOK,
            'token_type_id' => \App\TokenType::USER_ID,
        ]);

        Auth::login($user);

        $fakeFacebookResponse = '{"data":[{"access_token":"EAACEdE...","category":"Brand","category_list":[{"id":"1605186416478696","name":"Brand"}],"name":"Ash Cat Page","id":"1353269864728879","tasks":["ANALYZE","ADVERTISE","MODERATE","CREATE_CONTENT","MANAGE"]},{"access_token":"EAACEdE...","category":"Pet Groomer","category_list":[{"id":"163003840417682","name":"Pet Groomer"},{"id":"2632","name":"Pet"}],"name":"Unofficial: Tigger the Cat","id":"1755847768034402","tasks":["ANALYZE","ADVERTISE","MODERATE","CREATE_CONTENT"]}]}';
        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class)->shouldReceive('getBody')->andReturn($fakeFacebookResponse)->getMock();
        $guzzleMock = Mockery::mock(\GuzzleHttp\Client::class)->shouldReceive('request')->andReturn($responseMock)->getMock();
        $user->setupPages($guzzleMock);
        $page1 = Page::where('social_media_id', '1353269864728879')->first();
        $page2 = Page::where('social_media_id', '1755847768034402')->first();

        $this->assertTrue(!empty($page1));
        $this->assertTrue(!empty($page2));
    }
}
