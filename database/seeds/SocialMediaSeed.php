<?php

use Illuminate\Database\Seeder;

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
        DB::table('social_media')->insert(
            ['name' => 'Twitter']
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
    }
}
