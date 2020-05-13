<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_jobs', function (Blueprint $table) {
            $table->tinyInteger('pending_interviews')->default(0)->nullable();
            $table->tinyInteger('interview_scheduled')->default(0)->nullable();
            $table->tinyInteger('contract_signed')->default(0)->nullable();
            $table->tinyInteger('work_started')->default(0)->nullable();
            $table->tinyInteger('submitted_for_review')->default(0)->nullable();
            $table->tinyInteger('approved_by_employer')->default(0)->nullable();
            $table->tinyInteger('payment_completed')->default(0)->nullable();
            $table->tinyInteger('employee_reviewed')->default(0)->nullable();
            $table->tinyInteger('employer_reviewed')->default(0)->nullable();
            $table->tinyInteger('employee_rejected')->default(0)->nullable();
            $table->tinyInteger('employer_rejected')->default(0)->nullable();
            $table->tinyInteger('employee_cancelled')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_jobs', function (Blueprint $table) {
            //
        });
    }
}