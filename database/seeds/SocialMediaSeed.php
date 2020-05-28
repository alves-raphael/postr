<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SocialMediaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social_media')->insert(
            ['name' => 'Facebook']
        );

        DB::table('token_types')->insert(
            ['name' => 'User']
        );
        DB::table('token_types')->insert(
            ['name' => 'Page']
        );
        DB::table('token_types')->insert(
            ['name' => 'App']
        );
        DB::table('token_types')->insert(
            ['name' => 'user_id']
        );

        DB::table('users')->insert(
            [
                'name' => 'robot',
                'email' => 'robot@example.com',
                'api_token' => Str::random(60)
            ]
        );
    }
}
