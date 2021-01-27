<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('duration')->nullable();
            $table->string('price')->nullable();
            $table->string('popup_title')->nullable();
            $table->string('popup_description')->nullable();
            $table->string('popup_second_title')->nullable();
            $table->text('popup_first_bullets')->nullable();
            $table->string('popup_third_title')->nullable();
            $table->text('popup_second_bullets')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_tiles');
    }
}
