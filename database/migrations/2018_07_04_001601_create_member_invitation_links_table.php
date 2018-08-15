<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberInvitationLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_invitation_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->string('email')->nullable(true)->comment('メールアドレス');
            $table->string('token')->comment('トークン')->unique();
            $table->integer('expired_at')->nullable(true)->unsigned()->comment('有効期限');
            $table->integer('created_by')->nullable(true)->unsigned()->comment('作成者');
            $table->integer('updated_by')->nullable(true)->unsigned()->comment('更新者');
            $table->integer('created_at')->nullable()->unsigned();
            $table->integer('updated_at')->nullable()->unsigned();
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
        Schema::dropIfExists('member_invitation_links');
    }
}
