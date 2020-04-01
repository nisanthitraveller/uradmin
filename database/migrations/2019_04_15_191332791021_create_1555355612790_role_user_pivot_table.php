<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create1555355612790RoleUserPivotTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('role_user');
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
