<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlanDepartQuestionTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('plan_depart_questions', function (Blueprint $table) {

            $table->increments('id');
            $table->string('question')->comment('问题');
            $table->string('answers')->comment('答案');
            $table->string('status')->default('未开始')->comment('问题状态 ‘未开始’，‘调查中’，‘审核中’，‘审核成功’，‘已驳回’');
            $table->string('client_answer')->nullable()->comment('客户回答');
            $table->string('client_answer_editer')->nullable()->comment('调查过程执行人');
            $table->string('auditer')->nullable()->comment('问题审核人');
            $table->string('audit_text')->nullable()->comment('审核备注');
            $table->string('audit_at')->nullable()->comment('审核时间');
            $table->longText('more_files')->nullable()->comment('补充材料 图片url 数组');
            $table->longText('confirm_text')->nullable()->comment('现场确认内容 需要富文本');
            $table->string('confirm_editer')->nullable()->comment('现场确认执行人');
            $table->dateTime('confirm_at')->nullable()->comment('现场确认内容编辑时间');
            $table->string('conclusion_status')->nullable()->comment('最终结论严重性');
            $table->dateTime('conclusion_at')->nullable()->comment('最终结论 编辑时间');
            $table->longText('conclusion')->nullable()->comment('最终结论 需要富文本');
            $table->string('conclusion_editer')->nullable()->comment('最终结论执行人');

            $table->integer('plan_depart_id')->unsigned();
            $table->foreign('plan_depart_id')->references('id')->on('plan_departs')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('plan_depart_questions');
    }
}
