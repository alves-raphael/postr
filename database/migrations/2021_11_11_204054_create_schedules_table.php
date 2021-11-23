<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('weekday');
            $table->time('time');
            $table->unsignedInteger('social_media_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('social_media_id')->references('id')->on('social_media');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('schedules');
    }
}
