<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token')->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('social_media_id');
            $table->unsignedInteger('token_type_id');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->timestamp('expiration')->nullable();
            $table->timestamps();

            $table->foreign('social_media_id')->references('id')->on('social_media');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('token_type_id')->references('id')->on('token_types');
            $table->foreign('page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
