<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use ReflectionClass;

class GenerateModelUnitTest extends Command
{
    protected $signature = 'generate:model-test {module} {model}';
    protected $description = 'Generate a unit test for a model or entity based on its fillable, casts, and rules attributes';

    public function handle()
    {
        $module = $this->argument('module');
        $model = $this->argument('model');

        // Determine the model namespace and path based on the module structure
        $modelNamespace = Str::studly($model);
        $modelPath = base_path("Modules/{$module}/Entities/{$modelNamespace}.php");

        // Check if the entity or model exists
        if (!file_exists($modelPath)) {
            $this->error("Entity or Model $modelNamespace not found in the modules directory.");
            return;
        }

        // Determine the namespace for entities or models
        $entityNamespace = "Modules\\{$module}\\Entities";

        // Get the fillable, casts, and rules properties of the entity or model
        $modelClass = "{$entityNamespace}\\{$modelNamespace}";
        $reflectionClass = new ReflectionClass($modelClass);
        $fillable = $reflectionClass->getProperty('fillable')->getValue(new $modelClass);
        $casts = $this->getPropertyDefaultValue($reflectionClass, 'casts');
        $rules = $this->getPropertyDefaultValue($reflectionClass, 'rules');

        // Generate the unit test file content
        $content = view('commands.model_test', compact('module', 'model', 'fillable', 'casts', 'rules'))->render();

        // Specify the path where the test file will be saved
        $testPath = base_path("tests/Unit/{$model}Test.php");

        // Save the test file
        file_put_contents($testPath, $content);

        $this->info("Unit test for $modelNamespace in module $module has been generated at $testPath");
    }

    private function getPropertyDefaultValue($reflectionClass, $propertyName)
    {
        $property = $reflectionClass->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getDefaultValue();
    }
}
