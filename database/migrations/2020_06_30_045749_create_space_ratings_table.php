<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpaceRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('space_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rating')->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('team_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_name', 500)->nullable();
            $table->string('email', 250)->nullable();
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
        Schema::dropIfExists('space_ratings');
    }
}
