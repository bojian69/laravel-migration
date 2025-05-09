<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected function setC(Blueprint $table)
    {

    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pro_account', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');
            $table->comment('客户表');
            $table->timestamp('created_at')
                ->nullable(false)
                ->useCurrent()
                ->comment('创建时间');

            $table->timestamp('updated_at')
                ->nullable(false)
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('更新时间');
            $table->primary('id');


            $table->unsignedBigInteger('id')->comment('客户唯一标识');
            $table->unsignedTinyInteger('is_tester')->default(0)->comment('是否测试账号：0.否 1.是');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_account');
    }
};
