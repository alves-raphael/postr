<?php

use Illuminate\Database\Seeder;
use App\SocialMedia\Facebook;
use App\TokenType;
use App\Token;

class UsersTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Raphael',
            'email' => 'raphael@gmail.com',
        ]);

        $userAccessToken = new Token([
            'token' => 'asdaskljcnaqqn11980bn98b127xn12987x141739xnz12*&&)(*)',
            'token_type_id' => TokenType::USER_ACCESS,
        ]);
        $userAccessToken->setSocialMedia(new Facebook());
        $user->tokens()->save($userAccessToken);

        $userId = new Token([
            'token' => '123456789',
            'token_type_id' => TokenType::USER_ID,
        ]);

        $userId->setSocialMedia(new Facebook());
        $user->tokens()->save($userId);
    }
}