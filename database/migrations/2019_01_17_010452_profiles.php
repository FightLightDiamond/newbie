<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Profiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->unsignedInteger('round_one')->nullable();
            $table->unsignedInteger('round_two')->nullable();
            $table->unsignedInteger('round_three')->nullable();
            $table->text('image_one')->nullable();
            $table->text('image_two')->nullable();
            $table->text('image_three')->nullable();
            $table->string('website')->nullable();
            $table->string('hobby')->nullable();
            $table->string('slogan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
