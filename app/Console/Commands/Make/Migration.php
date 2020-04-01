<?php

namespace App\Console\Commands\Make;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Migration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Make:_migration {name}
      {--create= : The table to be created}
      {--table= : The table to migrate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration file in directory structure based on year/month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $date = Carbon::now();

        $path = database_path('migrations' . DIRECTORY_SEPARATOR . $date->year . DIRECTORY_SEPARATOR . $date->month);

        $name   = $this->argument('name');
        $table  = $this->option('table');
        $create = $this->option('create');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $this->call('make:migration', [
            'name'     => $name,
            '--create' => $create,
            '--table'  => $table,
            '--path'   => 'database' .
                          DIRECTORY_SEPARATOR .
                          'migrations' .
                          DIRECTORY_SEPARATOR .
                          $date->year .
                          DIRECTORY_SEPARATOR .
                          $date->month,
        ]);
    }
}
