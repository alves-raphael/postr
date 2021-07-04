<?php

namespace Tests\Feature;

use App\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use App\SocialMedia\Facebook;
use App\Token;
use App\TokenType;
use App\User;
use DateTime;
use Laravel\Socialite\Two\User as AbstractUser;

class FacebookTest extends TestCase
{

   use RefreshDatabase;

   public function setUp(): void
   {
      parent::setUp();
      $this->seed();
   }

   public function testSignUp()
   {
      $user = new User(['id' => 1]);

      $expiration = (new DateTime())->setTimestamp(time() + 5183944);
      $accessToken = (new Token())
         ->setToken("60d267addefc4")
         ->setTokenType(TokenType::USER_ACCESS)
         ->setExpiration($expiration)
         ->setSocialMediaId(1);
      
      $accessToken2 = (new Token())
         ->setToken("60de5c772f3bf")
         ->setTokenType(TokenType::USER_ACCESS)
         ->setExpiration($expiration)
         ->setSocialMediaId(1);
      $cuteKittenPage = (new Page())->setId(68738)->setName('Cute Kitten Page');
      
      $pages = collect([ [
         (new Token())
            ->setSocialMediaId(1)
            ->setToken('60cc0234607fe')
            ->setTokenType(TokenType::PAGE_ACCESS)
            ->setUser($user),
            $cuteKittenPage
         ]
      ]);

      $pages2 = collect([ [
         (new Token())
            ->setSocialMediaId(1)
            ->setToken('60de68716c5b9')
            ->setTokenType(TokenType::PAGE_ACCESS)
            ->setUser($user),
            $cuteKittenPage
         ]
      ]);
      
      $facebook = Mockery::mock(Facebook::class)->makePartial()
               ->shouldReceive('fetchLongLivedUserAccessToken')
               ->andReturn($accessToken, $accessToken2)
               ->shouldReceive('fetchPages')->andReturn($pages, $pages2)
               ->mock();
      
      $user = (new AbstractUser())
         ->map([
            'id' => 7127,
            'name' => "Raphael Alves",
            'email' => "raphael.alves@gmail.com",
            'token' => '60d278d59af5a'
         ]);
      
      $firstGottenUser = $facebook->signup($user);
      
      $secondUser = (new AbstractUser())
      ->map([
         'id' => 6546,
         'name' => "Jonisclayson",
         'email' => "jonisclayson.pinto@gmail.com",
            'token' => '60dcf9989938f'
         ]);
         
      $secondGottenUser = $facebook->signup($secondUser);

      $gottenToken = $firstGottenUser->getAccessToken($facebook);
      $this->assertEquals($firstGottenUser->email, $user->email);
      $this->assertEquals($firstGottenUser->name, $user->name);
      $this->assertEquals($gottenToken->token, $accessToken->token);
      $this->assertNotEmpty(Page::find(68738));
      $gottenPageToken = Token::where('token', '60cc0234607fe')->first();
      $this->assertNotEmpty($gottenPageToken);
      $secondUserPage = $secondGottenUser->pages;
      $this->assertEquals($secondUserPage->count(), 1);
      $this->assertEquals($secondUserPage->first()->name, 'Cute Kitten Page');
      $this->assertEquals($secondGottenUser->getUserId($facebook)->token, '6546');
      $this->assertEquals($firstGottenUser->getUserId($facebook)->token, '7127');
   }

   // public function testPublish()
   // {
   //    $id = rand(10000, 100000);
   //    $response = '{"id":"'.$id.'"}';
   //    $response = Mockery::mock(Response::class)
   //                ->shouldReceive('getBody')
   //                ->andReturn($response)->mock();
   //    $http = Mockery::mock(Client::class)
   //             ->shouldReceive('request')
   //             ->withSomeOfArgs('GET')
   //             ->andReturn($response)->mock();
   //    $facebook = Mockery::mock(Facebook::class)
   //                   ->makePartial()
   //                   ->shouldReceive([
   //                      'getPageAccessToken' => (new Token)->setToken(Str::random(10)),
   //                   ])->andSet('http', $http)->mock();
   //    $post = (new Post())
   //             ->setTitle('Simple Test')
   //             ->setBody('Tempor amet voluptate elit enim reprehenderit velit voluptate.')
   //             ->setSocialMedia($facebook)
   //             ->setUser(User::find(1));     
   //    $facebook->publish($post);
      
   // }

   public function tearDown(): void
   {
      parent::tearDown();
      Mockery::close();
   }
}
