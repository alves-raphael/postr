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
            ['name' => 'Facebook'],
            ['name' => 'Twitter']
        );
    }
}
