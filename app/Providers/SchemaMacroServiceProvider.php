<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;


class SchemaMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 注册表结构创建基础配置
        Blueprint::macro('standardConfig', function (string $tableName = '') {
            /** @var Blueprint $this */
            $this->engine('InnoDB');
            $this->charset('utf8mb4');
            $this->collation('utf8mb4_general_ci');
            $this->comment($tableName);

            $this->timestamp('created_at')
                ->nullable(false)
                ->useCurrent()
                ->comment('创建时间');

            $this->timestamp('updated_at')
                ->nullable(false)
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('更新时间');

            return $this;
        });

        // 注册表主键
        Blueprint::macro('primaryKey', function (string $column = 'id', string $comment = 'ID', bool $autoIncrement = false) {
            /** @var Blueprint $this */
            if ($autoIncrement) {
                $this->id($column)->comment($comment);
            } else {
                $this->unsignedBigInteger($column)->comment($comment);
                $this->primary($column);
            }
            return $this;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
