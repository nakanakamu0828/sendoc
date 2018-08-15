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
            $table->integer('organization_id')->unsigned();
            $table->string('title')->comment('タイトル');
            $table->string('invoice_no')->comment('請求No');

            $table->integer('client_id')->unsigned();
            $table->string('recipient')->comment('請求先（受取先）');
            $table->string('recipient_title')->nullable(true)->comment('請求先敬称');
            $table->string('recipient_contact')->nullable(true)->comment('請求先担当');

            $table->integer('source_id')->unsigned();
            $table->string('sender')->comment('請求元（差出人）');
            $table->string('sender_contact')->nullable(true)->comment('請求元担当');
            $table->string('sender_email')->nullable(true)->comment('請求元 メールアドレス');
            $table->string('sender_tel')->nullable(true)->comment('請求元 電話番号');
            $table->string('sender_postal_code', 8)->nullable(true)->comment('請求元 郵便番号');
            $table->string('sender_address1')->nullable(true)->comment('請求元 住所1');
            $table->string('sender_address2')->nullable(true)->comment('請求元 住所2');
            $table->string('sender_address3')->nullable(true)->comment('請求元 住所3');

            $table->integer('date')->unsigned()->comment('発行日');
            $table->integer('due')->nullable()->unsigned()->comment('支払期限');
            $table->boolean('in_tax')->default(true)->comment('税込みかどうか');
            $table->integer('tax_rate')->unsigned()->comment('税金（パーセンテージ）');
            $table->text('remarks')->nullable(true)->comment('備考');
            $table->double('subtotal', 15, 2)->default(0)->unsigned()->comment('小計');
            $table->double('tax', 15, 2)->default(0)->unsigned()->comment('税金');
            $table->double('total', 15, 2)->default(0)->unsigned()->comment('合計');
            $table->integer('created_by')->nullable(true)->unsigned()->comment('作成者');
            $table->integer('updated_by')->nullable(true)->unsigned()->comment('更新者');
            $table->integer('deleted_by')->nullable(true)->unsigned()->comment('削除者');
            $table->integer('created_at')->nullable()->unsigned();
            $table->integer('updated_at')->nullable()->unsigned();
            $table->integer('deleted_at')->nullable()->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');
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
