<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('verified')->default(false)->comment('認証判定');
            $table->string('email_token')->nullable()->comment('メールアドレス認証トークン');
            $table->timestamp('last_login_at')->nullable();      
            $table->string('created_ip', 16)->nullable()->comment('登録時IPアドレス');
            $table->string('updated_ip', 16)->nullable()->comment('最終更新時IPアドレス');
            $table->integer('created_at')->nullable()->unsigned();
            $table->integer('updated_at')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
