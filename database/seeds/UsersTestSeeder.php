<?php

use Illuminate\Database\Seeder;
use App\SocialMedia\Facebook;
use App\TokenType;
use App\Token;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Raphael',
                'email' => 'raphael@example.com',
            ]
        );
    }
}