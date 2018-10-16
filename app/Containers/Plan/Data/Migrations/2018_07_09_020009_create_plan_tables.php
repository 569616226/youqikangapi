<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlanTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->comment('库名称');
            $table->string('editer')->comment('编辑人');
            $table->boolean('is_parent')->default(false)->comment('是否是标准库');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('plans');
    }
}
