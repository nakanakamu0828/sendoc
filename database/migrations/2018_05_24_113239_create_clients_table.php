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
            $table->string('contact_name')->comment('担当者名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('postal_code', 8)->nullable(true)->comment('郵便番号');
            $table->integer('prefecture_id')->unsigned();
            $table->string('address1')->comment('住所');
            $table->string('address2')->nullable(true)->comment('建物など');
            $table->text('remarks')->nullable(true)->comment('備考');
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prefecture_id')->references('id')->on('prefectures')->onDelete('cascade')->onUpdate('cascade');
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
