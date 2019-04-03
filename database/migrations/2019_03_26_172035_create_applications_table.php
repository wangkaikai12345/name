<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->comment('应用名称');
            $table->string('app_id', 20)->comment('应用id');
            $table->integer('user_id')->comment('创建人id');
            $table->integer('domain_num')->default(0)->comment('域名个数');
            $table->integer('valid_num')->default(0)->comment('无效域名个数');
            $table->integer('status')->default(1)->comment('域名状态');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
