<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Schema\Comparator;
use Doctrine\DBAL\Schema\TableDiff;

class SyncDatabaseSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-database-schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected string $baselineConnection = 'pro_baseline';
    protected array $targetConnections = ['pro_basic', 'pro_vita'];

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $tables = DB::connection($this->baselineConnection)->getDoctrineSchemaManager()->listTableNames();

    }
}
