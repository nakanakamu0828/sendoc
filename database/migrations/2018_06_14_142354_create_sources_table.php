<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->string('name')->comment('屋号・氏名など');
            $table->string('contact_name')->nullable(true)->comment('担当者名');
            $table->string('email')->nullable(true)->comment('メールアドレス');
            $table->string('tel')->nullable(true)->comment('電話番号');
            $table->string('postal_code', 8)->nullable(true)->comment('郵便番号');
            $table->string('address1')->nullable(true)->comment('住所1');
            $table->string('address2')->nullable(true)->comment('住所2');
            $table->string('address3')->nullable(true)->comment('住所3');
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
