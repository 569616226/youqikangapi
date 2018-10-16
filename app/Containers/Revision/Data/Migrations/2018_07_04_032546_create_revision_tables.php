<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRevisionTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {

            $table->increments('id');
            $table->string('revisionable_type');
            $table->integer('revisionable_id');
            $table->integer('user_id')->nullable();
            $table->string('key');
            $table->longText('old_value')->nullable();
            $table->longText('new_value')->nullable();
            $table->string('device')->nullable();
            $table->string('ip')->nullable();
            $table->string('device_type')->nullable();
            $table->string('address')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('language')->nullable();
            $table->timestamps();

            $table->index(array('revisionable_id', 'revisionable_type'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('revisions');
    }
}
