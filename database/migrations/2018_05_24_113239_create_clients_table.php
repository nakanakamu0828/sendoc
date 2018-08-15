<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->string('name')->comment('会社名');
            $table->string('contact_name')->nullable(true)->comment('担当者名');
            $table->string('email')->nullable(true)->comment('メールアドレス');
            $table->string('tel')->nullable(true)->comment('電話番号');
            $table->string('postal_code', 8)->nullable(true)->comment('郵便番号');
            $table->string('address1')->nullable(true)->comment('住所1');
            $table->string('address2')->nullable(true)->comment('住所2');
            $table->string('address3')->nullable(true)->comment('住所3');
            $table->text('remarks')->nullable(true)->comment('備考');
            $table->integer('created_by')->nullable(true)->unsigned()->comment('作成者');
            $table->integer('updated_by')->nullable(true)->unsigned()->comment('更新者');
            $table->integer('created_at')->nullable()->unsigned();
            $table->integer('updated_at')->nullable()->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
