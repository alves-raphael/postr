<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->dateTime('publish')->useCurrent();
            $table->boolean('posted')->default(false);
            $table->unsignedInteger('topic_id')->nullable();
            $table->unsignedInteger('social_media_id');
            $table->unsignedInteger('user_id');
            $table->string('social_media_token')->nullable();
            $table->timestamps();

            $table->foreign('social_media_id')->references('id')->on('social_media');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
