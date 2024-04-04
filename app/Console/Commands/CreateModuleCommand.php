<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:create-module-command';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    protected $signature = 'module:create {name : The name of the module}';
    protected $description = 'Create a new module with the necessary folder structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('name');
        $modulePath = app_path("Modules/$moduleName");

        if (is_dir($modulePath)) {
            $this->error("Module '$moduleName' already exists!");
            return;
        }

        if (!mkdir($modulePath, 0755, true)) {
            $this->error("Unable to create directory '$modulePath'");
            return;
        }

        $directories = [
            'Providers',
            'Routes',
            'Controllers',
            'Views',
            'Models',
            'Migrations',
        ];

        foreach ($directories as $directory) {
            $directoryPath = "$modulePath/$directory";
            if (!mkdir($directoryPath, 0755, true)) {
                $this->error("Unable to create directory '$directoryPath'");
                return;
            }
            $this->info("Created directory '$directoryPath'");
        }

        $this->info("Module '$moduleName' created successfully!");
    }
}
