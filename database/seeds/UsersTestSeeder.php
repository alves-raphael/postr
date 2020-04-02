<?php

use Illuminate\Database\Seeder;

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

        $userAccessToken = \App\Token::create([
            'token' => 'asdaskljcnaqqn11980bn98b127xn12987x141739xnz12*&&)(*)',
            'user_id' => $user->id,
            'social_media_id' => \App\SocialMedia::FACEBOOK,
            'token_type_id' => \App\TokenType::USER_ACCESS,
        ]);

        $userAccessToken = \App\Token::create([
            'token' => '123456789',
            'user_id' => $user->id,
            'social_media_id' => \App\SocialMedia::FACEBOOK,
            'token_type_id' => \App\TokenType::USER_ID,
        ]);
    }
}
