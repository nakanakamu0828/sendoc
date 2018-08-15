<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcePayeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_payees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_id')->unsigned();
            $table->string('detail')->comment('詳細');
            $table->integer('created_by')->nullable(true)->unsigned()->comment('作成者');
            $table->integer('updated_by')->nullable(true)->unsigned()->comment('更新者');
            $table->integer('created_at')->nullable()->unsigned();
            $table->integer('updated_at')->nullable()->unsigned();
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('source_payees');
    }
}
