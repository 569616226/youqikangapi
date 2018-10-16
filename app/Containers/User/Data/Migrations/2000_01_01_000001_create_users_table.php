<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->commit('账号名');
            $table->string('username')->nullable()->commit('用户名');
            $table->string('password')->commit('密码');
            $table->boolean('confirmed')->default(false);
            $table->boolean('is_client')->default(false)->commit('是否是管理员');
            $table->boolean('is_frozen')->default(false)->commit('是否冻结');
            $table->boolean('is_audit')->default(false)->commit('是否是负责人');
            $table->boolean('is_client_admin')->default(false)->commit('是否是企业主，只有企业主才能分享');
            $table->string('wechat_name')->nullable()->commit('微信名');
            $table->string('wechat_avatar')->nullable()->commit('微信头像');
            $table->string('email')->unique()->nullable()->commit('邮箱');
            $table->string('open_id')->unique()->nullable()->commit('微信id');
            $table->dateTime('wechat_verfiy_time')->nullable()->commit('微信认证时间');
            $table->boolean('is_wechat_verfiy')->default(false)->commit('微信认证');
            $table->string('phone')->nullable()->unique()->commit('手机号码');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users');
    }
}

