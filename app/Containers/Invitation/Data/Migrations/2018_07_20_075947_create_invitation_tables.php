<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvitationTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {

            $table->increments('id');

            $table->string('code')->comment('分享授权码');
            $table->string('depart_ids')->comment('授权部门id数组');

            $table->integer('report_id')->unsigned();
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('invitations');
    }
}
