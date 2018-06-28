<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('タイトル');
            $table->integer('organization_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('source_id')->unsigned();
            $table->string('invoice_no')->comment('請求No');
            $table->date('date')->comment('発行日');
            $table->date('due')->nullable(true)->comment('支払期限');
            $table->boolean('in_tax')->default(true)->comment('税込みかどうか');
            $table->integer('tax_rate')->unsigned()->comment('税金（パーセンテージ）');
            $table->text('remarks')->nullable(true)->comment('備考');
            $table->double('subtotal', 15, 2)->default(0)->unsigned()->comment('小計');
            $table->double('tax', 15, 2)->default(0)->unsigned()->comment('税金');
            $table->double('total', 15, 2)->default(0)->unsigned()->comment('合計');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
