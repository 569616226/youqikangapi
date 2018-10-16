<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlanDepartTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('plan_departs', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->comment('库名部门名称');
            $table->string('icon')->nullable()->comment('库名部门图标');

            $table->integer('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('plan_departs');
    }
}
