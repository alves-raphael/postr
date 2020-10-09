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
use Illuminate\Support\Carbon;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp() : void {
        parent::setUp();
        $this->seed();
        $this->user = User::createRandom();
    }

    public function testPublish()
    {
        $this->seed(\UsersTestSeeder::class);

        $page = Page::create([
            'name' => 'random page',
            'social_media_token' => '123456789',
        ]);

        $this->user->pages()->attach($page->id);

        $token = [
            'token' => 'ankd98(*&(*NbhjBN(&h98&(&**YV564c65vbvb%$VE',
            'user_id' => $this->user->id,
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
        ->setUser($this->user);
            

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
        Auth::login($this->user);
        $post = (new Post([
            'title' => 'publicação de test', 
            'body' => 'Lorem ipsum dolor',
            'publication' => new DateTime('2020-07-01')
        ]))->setSocialMedia(new Facebook());

        $this->user->posts()->save($post);
        
        $response = $this->post('post/edit/'.$post->id, [
            'title' => "publicação de teste alterada",
            'body' => "Body changed",
            'publication' => '2020-08-01 15:00'
        ]);

        $post = Post::find($post->id);

        $this->assertEquals($post->title, "publicação de teste alterada");
        $this->assertEquals($post->body, "Body changed");
        $this->assertEquals($post->publication->format('Y-m-d H:i'), "2020-08-01 15:00");
        $response->assertStatus(302);
    }

    public function testTryEditPostFromSomeoneElse(){
        Auth::login($this->user);

        $anotherUser = User::createRandom();
        $anotherPost = (new Post([
            'title' => 'publicação de test 2', 
            'body' => 'Lorem ipsum dolor 2',
        ]))->setSocialMedia(new Facebook());
        $anotherUser->posts()->save($anotherPost);
        
        $this->post('post/edit/'.$anotherPost->id, [
            'title' => 'titulo alterado',
            'body' => 'corpo alterado'
            ]);
        $anotherPost = Post::find($anotherPost->id);

        $this->assertEquals('publicação de test 2', $anotherPost->title);
        $this->assertEquals('Lorem ipsum dolor 2', $anotherPost->body);
    }

    /**
     * Check if Post::isEditable() works properly
     */
    public function testIsEditable(){
        $postEditable = (new Post([
            'title' => 'publicação de test', 
            'body' => 'Lorem ipsum dolor',
            'publication' => new DateTime('2020-08-09')
        ]))->setSocialMedia(new Facebook());
        $this->user->posts()->save($postEditable);

        $notEditable = (new Post([
            'title' => 'publicação de test', 
            'body' => 'Lorem ipsum dolor',
            'publication' => new DateTime('2020-01-09')
        ]))->setSocialMedia(new Facebook());
        $this->user->posts()->save($notEditable);

        $this->assertTrue($postEditable->isEditable());
        $this->assertFalse($notEditable->isEditable());
    }

    /**
     * The post that have already been published, shall not be edited
     */
    public function testEditAlreadyPublishedPost(){
        
    }
}

