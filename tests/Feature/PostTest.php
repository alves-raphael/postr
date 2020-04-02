<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\SocialMedia;
use App\TokenType;
use App\Post;
use Mockery;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPublish()
    {
        $this->seed();
        $this->seed(\UsersTestSeeder::class);
        $user = \App\User::first();

        $page = \App\Page::create([
            'name' => 'random page',
            'social_media_token' => '123456789',
            'user_id' => $user->id
        ]);

        $token = \App\Token::create([
            'token' => 'ankd98(*&(*NbhjBN(&h98&(&**YV564c65vbvb%$VE',
            'user_id' => $user->id,
            'social_media_id' => SocialMedia::FACEBOOK,
            'token_type_id' => TokenType::PAGE_ACCESS,
            'page_id' => $page->id
        ]);
        $token->page()->associate($page);
        $token->save();

        $post = new Post();
        $post->title = 'publicação de teste';
        $post->body = 'Lorem Ipsum Dolor';
        $post->social_media_id = SocialMedia::FACEBOOK;
        $page->posts()->save($post);

        $facebookFakeResponse = '{"id": "123456789_1810399758992730"}';
        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class)->shouldReceive('getBody')->andReturn($facebookFakeResponse)->getMock();
        $guzzleMock = Mockery::mock(\GuzzleHttp\Client::class)->shouldReceive('request')->andReturn($responseMock)->getMock();

        $post->publish($guzzleMock);

        $post = Post::where('social_media_token', "123456789_1810399758992730")->first();

        $this->assertTrue(!empty($post));
        $this->assertTrue($post->published);
    }
}
