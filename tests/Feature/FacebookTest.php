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

   public function testFetchUserOrSignUp()
   {
      $page1 = factory(Page::class)->make();
      $user = factory(User::class)->create(['email' => 'raphael.alves@gmail.com']);
      $user->pages()->save($page1);

      $page2 = factory(Page::class)->make();
      $pages = collect([[1, $page1], [factory(Token::class)->make(), $page2]]);

      $abstractUser = (new AbstractUser())
         ->map([
            'email' => "raphael.alves@gmail.com",
         ]);

      $facebook = Mockery::mock(Facebook::class)
                  ->makePartial()
                  ->shouldReceive('signup')
                  ->andReturn($user)
                  ->shouldReceive('fetchPages')
                  ->andReturn($pages)
                  ->mock();

      $facebook->fetchUserOrSignUp($abstractUser);
      
      $this->assertNotEmpty($user->pages->find($page1->id)->first());
      $this->assertNotEmpty($user->pages->find($page2->id)->first());
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

      $firstGottenUser = $facebook->fetchUserOrSignUp($user);

      $secondUser = (new AbstractUser())
         ->map([
            'id' => 6546,
            'name' => "Jonisclayson",
            'email' => "jonisclayson.pinto@gmail.com",
               'token' => '60dcf9989938f'
            ]);

      $secondGottenUser = $facebook->fetchUserOrSignUp($secondUser);

      $gottenToken = $firstGottenUser->getAccessToken($facebook);
      $this->assertEquals($firstGottenUser->email, $user->email);
      $this->assertEquals($firstGottenUser->name, $user->name);
      $this->assertEquals($firstGottenUser->pages()->count(), 1);
      $this->assertEquals($gottenToken->token, $accessToken->token);
      $this->assertNotEmpty(Page::find(68738));
      $gottenPageToken = Token::where('token', '60cc0234607fe')->first();
      $this->assertNotEmpty($gottenPageToken);
      $this->assertEquals($secondGottenUser->pages()->count(), 1);
      $this->assertEquals($secondGottenUser->pages()->first()->name, 'Cute Kitten Page');
      $this->assertEquals($secondGottenUser->getUserId($facebook)->token, '6546');
      $this->assertEquals($firstGottenUser->getUserId($facebook)->token, '7127');
   }

   public function tearDown(): void
   {
      parent::tearDown();
      Mockery::close();
   }
}
