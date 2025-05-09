<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    // 定义需要同步的表
    protected array $tablesToSync = ['pro_refs', 'pro_form_field_component'];
    // 定义目标数据库连接
    protected array $targetConnections = ['pro_basic', 'pro_vita'];
    // 基线数据库链接
    protected string $baselineConnection = 'pro_baseline';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tablesToSync as $table) {
            // 同步表结构
            if (!Schema::connection($this->baselineConnection)->hasTable($table)) {
                continue; // 如果基线数据库中不存在该表，跳过
            }

            foreach ($this->targetConnections as $connection) {
                if (!Schema::connection($connection)->hasTable($table)) {
                    // 如果目标数据库中不存在该表，创建表结构
                    Schema::connection($connection)->create($table, function ($tableBlueprint) use ($table) {
                        $columns = Schema::connection($this->baselineConnection)->getColumnListing($table);
                        foreach ($columns as $column) {
                            $columnType = Schema::connection($this->baselineConnection)($table, $column)->getType()->getName();

                            $tableBlueprint->addColumn($columnType, $column);
                        }
                    });
                }
            }


            Schema::connection($this->baselineConnection)
                ->getConnection()
                ->getSchemaBuilder()
                ->table($tableToSync, function (Blueprint $table) {
                    // 打印 $table 信息
                    dump([
                        'table_name' => $table->getTable(),
                        'columns' => $table->getAddedColumns(), // 检查是否能获取列
                    ]);
                });

            $tableToSync = 'pro_refs';
            $connection = Schema::connection($this->baselineConnection)->getConnection();
            $columns = $connection->getSchemaBuilder()->getColumns($tableToSync);
            // 同步表结构到 pro_basic 和 pro_vita
            foreach ($this->databasesToSync as $connection) {
                Schema::connection($connection)->create($tableToSync, function (Blueprint $newTable) use ($columns) {
                    foreach ($columns as $column) {
                        $newTable->addColumn($column->getType(), $column->getName(), $column->getAttributes());
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tablesToSync as $table) {
            foreach ($this->databasesToSync as $connection) {
                // 删除目标数据库中的表
                Schema::connection($connection)->dropIfExists($table);
            }
        }
    }
};
