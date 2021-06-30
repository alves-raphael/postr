<?php

namespace Tests\Feature;

use App\Page;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use App\SocialMedia\Facebook;
use App\Token;
use App\TokenType;
use App\User;
use Facade\FlareClient\Http\Response;
use GuzzleHttp\Client;
use Laravel\Socialite\Two\User as AbstractUser;
use Illuminate\Support\Str;

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

      $accessToken = (new Token())
                    ->setToken("60d267addefc4")
                    ->setTokenType(TokenType::USER_ACCESS)
                    ->setExpiration(time() + 5183944)
                    ->setSocialMediaId(1);

      $pages = collect([ [
            (new Token())
                  ->setSocialMediaId(1)
                  ->setToken('60cc0234607fe')
                  ->setTokenType(TokenType::PAGE_ACCESS)
                  ->setUser($user),
            (new Page())
                  ->setId(68738)
                  ->setName('Cute Kitten Page')
         ],[
            (new Token())
                  ->setSocialMediaId(1)
                  ->setToken('60d3d68169e70')
                  ->setTokenType(TokenType::PAGE_ACCESS)
                  ->setUser($user),
            (new Page())
                  ->setId(6335)
                  ->setName('Cute Kitten Page 2')
         ]
      ]);

      $facebook = Mockery::mock(Facebook::class)
                           ->makePartial()
                           ->shouldReceive([
                              'fetchLongLivedUserAccessToken' => $accessToken,
                              'fetchPages' => $pages
                           ])->mock();

      $user = (new AbstractUser())
               ->map([
                  'id' => 7127,
                  'name' => "Raphael Alves",
                  'email' => "raphael.alves@gmail.com",
                  'token' => '60d278d59af5a'
               ]);

      $gottenUser = $facebook->signup($user);

      $gottenToken = $gottenUser->tokens()->where('token_type_id', TokenType::USER_ACCESS)->first();
      $this->assertEquals($gottenUser->email, $user->email);
      $this->assertEquals($gottenUser->name, $user->name);
      $this->assertEquals($gottenToken->token, $accessToken->token);
      $this->assertNotEmpty(Page::find(68738));
      $this->assertNotEmpty(Page::find(6335));
      $gottenPageToken = Token::where('token', '60d3d68169e70')->first();
      $this->assertNotEmpty($gottenPageToken);
   }

   public function testPublish()
   {
      $id = rand(10000, 100000);
      $response = '{"id":"'.$id.'"}';
      $response = Mockery::mock(Response::class)
                  ->shouldReceive('getBody')
                  ->andReturn($response)->mock();
      $http = Mockery::mock(Client::class)
               ->shouldReceive('request')
               ->withSomeOfArgs('GET')
               ->andReturn($response)->mock();
      $facebook = Mockery::mock(Facebook::class)
                     ->makePartial()
                     ->shouldReceive([
                        'getPageAccessToken' => (new Token)->setToken(Str::random(10)),
                     ])->andSet('http', $http)->mock();
      $post = (new Post())
               ->setTitle('Simple Test')
               ->setBody('Tempor amet voluptate elit enim reprehenderit velit voluptate.')
               ->setSocialMedia($facebook)
               ->setUser(User::find(1));     
      $facebook->publish($post);
      
   }

   public function tearDown(): void
   {
      parent::tearDown();
      Mockery::close();
   }
}
