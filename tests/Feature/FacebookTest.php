<?php

namespace Tests\Feature;

use App\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use App\SocialMedia\Facebook;
use App\Token;
use App\TokenType;
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

      $accessToken = (new Token())
                    ->setToken("60d267addefc4")
                    ->setTokenType(TokenType::USER_ACCESS)
                    ->setExpiration(time() + 5183944)
                    ->setSocialMediaId(1);

      $pages = collect([ [
            (new Token())
                  ->setSocialMediaId(1)
                  ->setToken('60cc0234607fe')
                  ->setTokenType(TokenType::PAGE_ACCESS),
            (new Page())
                  ->setId(68738)
                  ->setName('Cute Kitten Page')
         ] ]);

      $facebook = Mockery::mock(Facebook::class)
                           ->makePartial()
                           ->shouldReceive([
                              'fetchLongLivedUserAccessToken' => $accessToken,
                              'fetchPages' => $pages
                           ])->mock();

      $user = (new AbstractUser)
               ->map([
                  'id' => 7127,
                  'name' => "Raphael Alves",
                  'email' => "raphael.alves@gmail.com",
                  'token' => '60d278d59af5a'
               ]);

      $got = $facebook->signup($user);
      $gotToken = $got->tokens()->where('token_type_id', TokenType::USER_ACCESS)->first();
      $this->assertEquals($got->email, $user->email);
      $this->assertEquals($got->name, $user->name);
      $this->assertEquals($gotToken->token, $accessToken->token);
   }

   public function tearDown(): void
   {
      parent::tearDown();
      Mockery::close();
   }
}
