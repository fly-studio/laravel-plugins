<?php

namespace Plugins\System\App\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;

class AlterDatePartitionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:date-partition {table_name : Table Name}
                    {--field=created_at : Which field to partition.}
                    {--step=1 : How many days per a partition.}
                    {--start=now : When do the partition start.}
                    {--count=15 : How many partitions that your wanna created.}
                    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alter a table\'s partitions of date.';


    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {
        $table_name = $this->argument('table_name');
        $start = strtotime($this->option('start'));
        $step = intval($this->option('step')) ?? 1;
        $field = $this->option('field');
        $count = $this->option('count');

        if (empty($start))
            return $this->error('--start MUST be a valid date string, and has no time string');

        $start = Carbon::createFromTimestamp($start)->startOfDay();
        $range = [];

        for($i = 0; $i < $count; ++$i)
        {
            $range[] = $start->toDateString();
            $start->addDays($step);
        }

        $partition_names = \DB::select('select `partition_name` from `INFORMATION_SCHEMA`.`PARTITIONS` where `TABLE_SCHEMA` = ? and `table_name`= ? order by `partition_ordinal_position` DESC;', [env('DB_DATABASE'), $table_name]);

        $partition_names = array_filter(array_map( function($v){
            return ((object)$v)->partition_name;
        }, $partition_names), function($v) {
            return !is_null($v);
        });

        $range = array_diff($range, $partition_names);

        $partitions = [];
        foreach($range as $date)
            $partitions[] = 'PARTITION `'.$date.'` VALUES LESS THAN ('.(strtotime($date) + 86400).')';

        if (empty($partition_names))
        {
            $this->ask('This table has no partitions.'.PHP_EOL.' - Is `'.$field.'` a PRIMARY KEY? Please set it as PK.'.PHP_EOL.' - And the table `'.$table_name.'` has no foreign keys? Please drop all foreign keys in this table.'.PHP_EOL.'(If ready. press any key to continue)');
// PARTITION `max` VALUES LESS THAN (MAXVALUE) MUST not be added
            $sql = 'ALTER TABLE `'.$table_name.'` PARTITION BY RANGE (unix_timestamp(`'.$field.'`))(%s);';
        } else {
            $this->comment('This table exists partitions.'.PHP_EOL);

            $sql = 'ALTER TABLE `'.$table_name.'` ADD PARTITION (%s);';
        }

        $sql = sprintf($sql, implode(','.PHP_EOL, $partitions));



        $this->info($sql);
        if ($this->ask('You may create these partitions? [y/n]', 'y') != 'y')
            return $this->warn('User Aborted.');

        try {
            $this->warn('Execute it, Please Waiting...');
            \DB::statement($sql);
            $this->info('Done.');

        } catch (\Exception $e)
        {
            $this->error('Failed.'. $e->getMessage());
        }
    }

}
