<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScanSecurity extends Command
{
    protected $signature = 'security:scan {modules?*}';
    protected $description = 'Scan for potentially vulnerable controllers and models';

    public function handle()
    {
        $modulesToScan = $this->argument('modules') ?: [];

        // Scan controllers
        $this->info('Scanning controllers...');
        $this->scanControllers($modulesToScan);

        // Scan models
        $this->info('Scanning models...');
        $this->scanModels($modulesToScan);
    }

    private function scanControllers($modulesToScan)
    {
        $modulesPath = base_path('Modules');

        $moduleDirectories = $this->getModuleDirectories($modulesPath, $modulesToScan);

        foreach ($moduleDirectories as $moduleDirectory) {
            $controllersPath = $moduleDirectory . '/Http/Controllers';

            if (file_exists($controllersPath)) {
                $controllerFiles = File::allFiles($controllersPath);

                foreach ($controllerFiles as $file) {
                    $content = file_get_contents($file->getPathname());

                    // Check for mass assignment vulnerability
                    if (strpos($content, 'protected $fillable') !== false) {
                        $this->warn('Potential mass assignment vulnerability in: ' . $file->getRelativePathname());
                        $this->comment('Consider using guarded or only fillable attributes to enhance security.');
                    }
                }
            }
        }
    }

    private function scanModels($modulesToScan)
    {
        $modulesPath = base_path('Modules');

        $moduleDirectories = $this->getModuleDirectories($modulesPath, $modulesToScan);

        foreach ($moduleDirectories as $moduleDirectory) {
            $modelsPath = $moduleDirectory . '/Entities';

            if (file_exists($modelsPath)) {
                $modelFiles = File::allFiles($modelsPath);

                foreach ($modelFiles as $file) {
                    $content = file_get_contents($file->getPathname());

                    // Check for mass assignment vulnerability
                    if (strpos($content, 'protected $fillable') !== false) {
                        $this->warn('Potential mass assignment vulnerability in: ' . $file->getRelativePathname());
                        $this->comment('Consider using guarded or only fillable attributes to enhance security.');
                        $this->comment('Example: protected $guarded = []; // Allow all attributes to be mass assigned');
                    }
                }
            }
        }
    }

    private function getModuleDirectories($modulesPath, $modulesToScan)
    {
        if (empty($modulesToScan)) {
            return array_filter(glob($modulesPath . '/*'), 'is_dir');
        }

        return array_map(function ($module) use ($modulesPath) {
            return $modulesPath . '/' . $module;
        }, $modulesToScan);
    }
}
