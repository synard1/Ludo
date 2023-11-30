<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('formatArray', function ($expression) {
            return "<?php echo formatArray($expression); ?>";
        });
    }

    public function register()
    {
        //
    }
}
