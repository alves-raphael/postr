<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TokenPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_page', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('token_id');
            $table->unsignedInteger('page_id');
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages');
            $table->foreign('token_id')->references('id')->on('tokens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
