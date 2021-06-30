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
            $table->string('id')->primary();
            $table->string('title');
            $table->text('body');
            $table->dateTime('publication')->useCurrent();
            $table->boolean('published')->default(false);
            $table->unsignedInteger('topic_id')->nullable();
            $table->unsignedInteger('social_media_id');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('social_media_id')->references('id')->on('social_media');
            $table->foreign('page_id')->references('id')->on('pages');
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
