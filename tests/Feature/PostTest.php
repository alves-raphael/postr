<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\{Post, User, Page, TokenType, Token};

class PostTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFetchPageAccess()
    {
        $page = factory(Page::class)->create();
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $post1 = factory(Post::class)
                ->create([
                    'user_id' => $user1->id,
                    'page_id' => $page->id
                    ]);
        $post2 = factory(Post::class)
                ->create([
                    'user_id' => $user2->id,
                    'page_id' => $page->id
                    ]);
        $tokens = factory(Token::class, 2)
                ->make([
                    'token_type_id' => TokenType::PAGE_ACCESS,
                    'page_id' => $page->id
                ]);
        factory(Token::class, 2)->create();
                
        $user1->tokens()->save($tokens[0]);
        $user2->tokens()->save($tokens[1]);
        
        $this->assertEquals($tokens[0]->token, $post1->fetchPageAccess()->token);
        $this->assertEquals($tokens[1]->token, $post2->fetchPageAccess()->token);
    }
}
