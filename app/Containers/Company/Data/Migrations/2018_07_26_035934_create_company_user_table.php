<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyUserTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('company_user', function (Blueprint $table) {

            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['company_id', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('company_user');
    }
}
