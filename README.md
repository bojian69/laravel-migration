
### 
laravel-migration 数据库结构迁移

### Usage

项目搭建配置
```bash

```

命令说明：

```bash
# 生成迁移文件
php artisan make:migration create_flights_table

# 运行迁移 or 指定数据库
php artisan migrate

php artisan migrate:fresh --database=pro_basic
# 查看已运行迁移
php artisan migrate:status

# PS：仅查看迁移执行SQL不运行
php artisan migrate --pretend

# 回滚迁移 or 多个迁移 
php artisan migrate:rollback

php artisan migrate:rollback --step=5
```

### 注意事项
