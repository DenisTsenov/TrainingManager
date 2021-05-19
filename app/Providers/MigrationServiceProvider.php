<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(database_path('migrations'), RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
        );

        $paths = [];
        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[] = $path;
            }
        }

        $this->loadMigrationsFrom($paths);
    }
}
