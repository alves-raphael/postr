<?php

namespace Tests\Unit;

use App\Page;
use App\SocialMedia\Facebook;
use App\Token;
use App\TokenType;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Laravel\Socialite\AbstractUser;
use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

class FacebookTest extends TestCase
{
    public function testFetchPages() {
        $response = '{"data":[{"access_token":"60cc0234607fe","category":"Brand","category_list":[{"id":"1605186416478696","name":"Brand"}],"name":"Cute Kitten Page","id":"68738","tasks":["ANALYZE","ADVERTISE","MODERATE","CREATE_CONTENT","MANAGE"]}],"paging":{"cursors":{"before":"MTM1MzI2OTg2NDcyODg3OQZDZD","after":"MTM1MzI2OTg2NDcyODg3OQZDZD"}}}';
        $response = Mockery::mock(Response::class)
                    ->shouldReceive('getBody')
                    ->andReturn($response)->mock();
        $mockHttp = Mockery::mock(Client::class)
                    ->shouldReceive('request')
                    ->withSomeOfArgs('GET')->andReturn($response)
                    ->mock();
        $facebook = new Facebook($mockHttp);

        $userId = (new Token())
                    ->setToken(Str::random(10))
                    ->setSocialMedia($facebook)
                    ->setTokenType(TokenType::USER_ID);
        
        $accessToken = (new Token())
                    ->setToken((string) rand(1000,10000))
                    ->setSocialMedia($facebook)
                    ->setTokenType(TokenType::USER_ID);

        $mockUser = Mockery::mock(User::class)
                    ->shouldReceive([
                        'getUserId' => $userId,
                        'getAccessToken' => $accessToken
                    ])->mock();
        $got = $facebook->fetchPages($mockUser);
        $expected = collect([
            [
            (new Token())
                ->setSocialMedia($facebook)
                ->setToken('60cc0234607fe')
                ->setTokenType(TokenType::PAGE_ACCESS),
            (new Page())
                ->setId(68738)
                ->setName('Cute Kitten Page')
            ]
        ]);
        $this->assertEquals($got, $expected);
   }

   public function tearDown(): void
   {
        parent::tearDown();
        Mockery::close();
   }
}
