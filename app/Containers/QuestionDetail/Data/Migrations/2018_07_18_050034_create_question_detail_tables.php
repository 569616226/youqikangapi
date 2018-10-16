<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionDetailTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('question_details', function (Blueprint $table) {

            $table->increments('id');
            $table->string('question')->comment('追加问题');
            $table->longText('answer')->comment('追加问题回答');

            $table->integer('plan_depart_question_id')->unsigned();
            $table->foreign('plan_depart_question_id')->references('id')->on('plan_depart_questions')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('question_details');
    }
}
