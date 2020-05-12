<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemoteJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remote_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('recruiter_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('price')->nullable();
            $table->string('duration')->nullable();
            $table->string('url')->nullable();
            $table->string('experience')->nullable();
            $table->string('label')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('remote_jobs');
    }
}
