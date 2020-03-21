<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaUserIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_user_ids', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->unsignedInteger('social_media_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            //Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('social_media_id')->references('id')->on('social_media');
            //Unique
            $table->unique(['social_media_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media_user_ids');
    }
}
