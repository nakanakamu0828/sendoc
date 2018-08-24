<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('name')->comment('氏名');
            $table->date('birthday')->nullable()->comment('生年月日');
            $table->tinyInteger('sex')->unsigned()->default(0)->comment('性別 0:未設定, 1:男性, 2:女性, 9:未回答');
            $table->string('tel', 20)->nullable()->comment('電話番号');
            $table->string('url')->nullable()->comment('URL');
            $table->string('image')->nullable()->comment('画像');
            $table->integer('created_at')->nullable()->unsigned();
            $table->integer('updated_at')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
