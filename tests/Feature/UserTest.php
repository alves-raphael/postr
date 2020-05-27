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
        $this->seed(\UsersTestSeeder::class);

        $user = User::where('email','raphael@gmail.com')->first();

        $fakeFacebookResponse = '{"data":[{"access_token":"EAACEdE...","category":"Brand","category_list":[{"id":"1605186416478696","name":"Brand"}],"name":"Ash Cat Page","id":"1353269864728879","tasks":["ANALYZE","ADVERTISE","MODERATE","CREATE_CONTENT","MANAGE"]},{"access_token":"EAACEdE...","category":"Pet Groomer","category_list":[{"id":"163003840417682","name":"Pet Groomer"},{"id":"2632","name":"Pet"}],"name":"Unofficial: Tigger the Cat","id":"1755847768034402","tasks":["ANALYZE","ADVERTISE","MODERATE","CREATE_CONTENT"]}]}';
        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class)->shouldReceive('getBody')->andReturn($fakeFacebookResponse)->getMock();
        $guzzleMock = Mockery::mock(\GuzzleHttp\Client::class)->shouldReceive('request')->andReturn($responseMock)->getMock();
        $user->setupPages($guzzleMock);
        $page1 = Page::where('social_media_token', '1353269864728879')->first();
        $page2 = Page::where('social_media_token', '1755847768034402')->first();

        $this->assertTrue(!empty($page1));
        $this->assertTrue(!empty($page2));
    }

    public function testTwoUsersWithTheSamePage(){
        $this->seed();
        
        $first = User::createRandom();
        $second = User::createRandom();        

        $fakeFacebookResponse = '{"data":[{"access_token":"EAACEdE...","category":"Brand","category_list":[{"id":"1605186416478696","name":"Brand"}],"name":"Ash Cat Page","id":"1353269864728879","tasks":["ANALYZE","ADVERTISE","MODERATE","CREATE_CONTENT","MANAGE"]},{"access_token":"EAACEdE...","category":"Pet Groomer","category_list":[{"id":"163003840417682","name":"Pet Groomer"},{"id":"2632","name":"Pet"}],"name":"Unofficial: Tigger the Cat","id":"1755847768034402","tasks":["ANALYZE","ADVERTISE","MODERATE","CREATE_CONTENT"]}]}';
        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class)->shouldReceive('getBody')->andReturn($fakeFacebookResponse)->getMock();
        $guzzleMock = Mockery::mock(\GuzzleHttp\Client::class)->shouldReceive('request')->andReturn($responseMock)->getMock();
        $first->setupPages($guzzleMock);
        $second->setupPages($guzzleMock);

        $page1 = Page::where('social_media_token', '1353269864728879')->first();
        $page2 = Page::where('social_media_token', '1755847768034402')->first();

        // Test if the pages were successfully registered
        $this->assertTrue(!empty($page1));
        $this->assertTrue(!empty($page2));

        $page1 = $first->pages()->where('social_media_token', '1353269864728879')->first();
        $page2 = $first->pages()->where('social_media_token', '1755847768034402')->first();
        
        // Check if the pages were associated with the first user
        $this->assertTrue(!empty($page1));
        $this->assertTrue(!empty($page2));

        $page1 = $second->pages()->where('social_media_token', '1353269864728879')->first();
        $page2 = $second->pages()->where('social_media_token', '1755847768034402')->first();
        
        // Check if the pages were associated with the second user
        $this->assertTrue(!empty($page1));
        $this->assertTrue(!empty($page2));
    }
}
