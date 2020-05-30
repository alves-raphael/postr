<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\SocialMedia\Facebook;
use App\TokenType;
use App\User;
use App\Http\Controllers\PostController;
use App\Post;
use Mockery;
use App\Page;
use Illuminate\Support\Facades\Auth;
use DateTime;

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
        $user = User::first();

        $page = Page::create([
            'name' => 'random page',
            'social_media_token' => '123456789',
        ]);

        $user->pages()->attach($page->id);

        $token = [
            'token' => 'ankd98(*&(*NbhjBN(&h98&(&**YV564c65vbvb%$VE',
            'user_id' => $user->id,
            'token_type_id' => TokenType::PAGE_ACCESS,
        ];
        $token = (new \App\Token($token))
                ->setSocialMedia(new Facebook())
                ->setPage($page);
        $token->save();

        $post = (new Post([
            'title' => 'publicação de teste',
            'body' => 'Lorem Ipsum Dolor'
        ]))->setSocialMedia(new Facebook())
        ->setUser($user);
            

        $page->posts()->save($post);

        $facebookFakeResponse = '{"id": "123456789_1810399758992730"}';
        $responseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class)->shouldReceive('getBody')->andReturn($facebookFakeResponse)->getMock();
        $guzzleMock = Mockery::mock(\GuzzleHttp\Client::class)->shouldReceive('request')->andReturn($responseMock)->getMock();

        $post->publish($guzzleMock);

        $post = Post::where('social_media_token', "123456789_1810399758992730")->first();

        $this->assertTrue(!empty($post));
        $this->assertTrue($post->published);
    }

    public function testEdit(){
        $this->seed();
        $user = User::createRandom();
        Auth::login($user);
        $post = (new Post([
            'title' => 'publicação de test', 
            'body' => 'Lorem ipsum dolor',
        ]))->setSocialMedia(new Facebook());

        $user->posts()->save($post);
        
        $response = $this->post('post/edit/'.$post->id, [
            'title' => "publicação de teste alterada"
        ]);

        $post = Post::find($post->id);

        $this->assertEquals($post->title, "publicação de teste alterada");
        $response->assertStatus(302);
    }

    public function testTryEditPostFromSomeoneElse(){
        $this->seed();
        $user = User::createRandom();
        Auth::login($user);
        $post = (new Post([
            'title' => 'publicação de test', 
            'body' => 'Lorem ipsum dolor',
        ]))->setSocialMedia(new Facebook());
        $user->posts()->save($post);
            
        $anotherUser = User::createRandom();
        $anotherPost = (new Post([
            'title' => 'publicação de test 2', 
            'body' => 'Lorem ipsum dolor 2',
        ]))->setSocialMedia(new Facebook());
        $anotherUser->posts()->save($anotherPost);
        
        $this->post('post/edit/'.$anotherPost->id, ['title' => 'titulo alterado']);
        $anotherPost = Post::find($anotherPost->id);

        $this->assertEquals('publicação de test 2', $anotherPost->title);
    }

    public function testIsEditable(){
        $this->seed();
        $user = User::createRandom();
        $postEditable = (new Post([
            'title' => 'publicação de test', 
            'body' => 'Lorem ipsum dolor',
            'publication' => new DateTime('2020-08-09')
        ]))->setSocialMedia(new Facebook());
        $user->posts()->save($postEditable);

        $notEditable = (new Post([
            'title' => 'publicação de test', 
            'body' => 'Lorem ipsum dolor',
            'publication' => new DateTime('2020-01-09')
        ]))->setSocialMedia(new Facebook());
        $user->posts()->save($notEditable);

        $this->assertTrue($postEditable->isEditable());
        $this->assertFalse($notEditable->isEditable());
    }
}

