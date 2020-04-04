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

        $userAccessToken = new \App\Token([
            'token' => 'asdaskljcnaqqn11980bn98b127xn12987x141739xnz12*&&)(*)',
            'social_media_id' => \App\SocialMedia::FACEBOOK,
            'token_type_id' => \App\TokenType::USER_ACCESS,
        ]);
        $user->tokens()->save($userAccessToken);

        $userId = new \App\Token([
            'token' => '123456789',
            'social_media_id' => \App\SocialMedia::FACEBOOK,
            'token_type_id' => \App\TokenType::USER_ID,
        ]);
        $user->tokens()->save($userId);
    }
}
