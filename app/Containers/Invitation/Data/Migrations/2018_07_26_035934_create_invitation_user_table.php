<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvitationUserTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invitation_user', function (Blueprint $table) {

            $table->integer('invitation_id')->unsigned();
            $table->foreign('invitation_id')->references('id')->on('invitations');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->boolean('is_client')->default(false)->comment('是否是使用人');

            $table->primary(['invitation_id', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('invitation_user');
    }
}
