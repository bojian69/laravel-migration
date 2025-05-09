<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pro_account', function (Blueprint $table) {
            $table->primaryKey('id', '客户标识');
            $table->unsignedTinyInteger('is_tester')->default(0)->comment('是否测试账号：0.否 1.是');
            $table->standardConfig('客户表');
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
