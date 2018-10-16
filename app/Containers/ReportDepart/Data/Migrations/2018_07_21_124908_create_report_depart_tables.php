<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportDepartTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('report_departs', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->comment('库名部门名称');
            $table->string('icon')->nullable()->comment('库名部门图标');

            $table->integer('report_id')->unsigned();
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('report_departs');
    }
}
